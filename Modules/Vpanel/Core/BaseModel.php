<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\File\Entities\File;
use Modules\Vpanel\Core\Fields\Field;

abstract class BaseModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected static ?ModelStructure $structure = null;

    public static function getStructure(): ?ModelStructure
    {
        return static::defineStructure();
    }

    public static function defineStructure(): ?ModelStructure
    {
        return null;
    }

    public static function getList(array $params = [])
    {
        $structure = static::getStructure();
        if (!$structure) {
            return null;
        }

        $page = $params['page'] ?? null;
        $filter = $params['filter'] ?? [];
        $search = $params['search'] ?? '';

        $tableName = with(new static)->getTable();
        $query = static::query()->addSelect(["{$tableName}.id"]);

        $fields = $structure->getFields();
        foreach ($fields as $field) {
            if ($field->isInEditor()) {
                $query->addSelect($field->getSelect(static::class));
            }

            $join = $field->getJoin(static::class);
            if (count($join) > 0) {
                $query->leftJoin(...$join);
            }

            if (count($filter) > 0) {
                $where = $field->getWhere(static::class, $filter);
                if ($where) {
                    if ($field->getType() === 'pointer') {
                        $query->whereIn(...$where);
                    } else if (is_array($where[0])) {
                        foreach ($where as $w) {
                            $query->where(...$w);
                        }
                    } else {
                        $query->where(...$where);
                    }
                }
            } else if (!empty($search) && $field->isInSearch()) {
                $query->orWhere($field->getName(), 'like', "%{$search}%");
            }
        }

        if ($structure->isSortable()) {
            $orderKey = 'sort';
            $orderDirection = 'asc';
        } else {
            $orderKey = 'id';
            $orderDirection = 'desc';
        }

        $query->orderBy("{$tableName}." . $orderKey, $orderDirection);

        if ($page > 0) {
            $paginatedList = $query->paginate(3, '[*]', 'page', $page);
            Utils::prepareModelData($paginatedList->getCollection());
            return $paginatedList;
        }

        return $query->get();
    }

    public static function getRecord($id)
    {
        $structure = static::getStructure();
        if (!$structure) {
            return null;
        }

        $tableName = with(new static)->getTable();

        $query = static::query()->addSelect(["{$tableName}.id"]);

        $fields = $structure->getFields();
        foreach ($fields as $field) {
            $query->addSelect($field->getSelect(static::class));

            $join = $field->getJoin(static::class);
            if (count($join) > 0) {
                $query->leftJoin(...$join);
            }
        }
        $query->where("{$tableName}.id", '=', $id);

        $record = $query->get();

        if ($structure->isSingle() && count($record) === 0) {
            return true;
        }

        Utils::prepareModelData($record);

        return $record[0];
    }

    public static function saveRecord($data, $id = 0, $files = [])
    {
        $structure = static::getStructure();
        if (!$structure) {
            return null;
        }

        $requiredFields = [];
        foreach ($structure->getFields() as $field) {
            foreach ($data as $key => $value) {
                if ($key === $field->getName() && (!$value || $value === 'null')) {
                    $data[$key] = $field->getDefaultValue();
                }
            }
            if ($field->isRequired()) {
                $requiredFields = [
                    ...$requiredFields,
                    $field->getName() => 'required'
                ];
            }
        }

        $validator = Validator::make($data, $requiredFields);

        if ($validator->fails()) {
            return [
                'recordId' => 0,
                'error' => $validator->messages()
            ];
        }

        $validatedData = $validator->getData();

        if (class_exists(File::class) && count($files) > 0) {
            foreach ($files as $key => $file) {
                $uploadedFile = File::uploadFile($file);
                if ($uploadedFile) {
                    $validatedData[$key] = $uploadedFile->id;
                }
            }
        }

        $record = static::query()->find($id);

        if ($record) {
            $record->update($validatedData);
        } else {
            $id = (static::query()->create($validatedData))->id;
        }

        return [
            'recordId' => $id,
            'error' => ''
        ];
    }

    public static function sortList($data): void {
        $records = static::query()
            ->whereIn('id', $data)
            ->get();

        foreach ($data as $key => $value) {
            foreach ($records as $record) {
                if ($value === $record->id) {
                    $record->sort = $key;
                    $record->save();
                    break;
                }
            }
        }
    }
}
