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

        $filter = $params["filter"] ?? [];
        $search = $params["search"] ?? "";
        $withPagination = $params["withPagination"] ?? false;

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
                    if ($field->getType() === "pointer") {
                        $query->whereIn(...$where);
                    }
                    else if (is_array($where[0])) {
                        foreach ($where as $w) {
                            $query->where(...$w);
                        }
                    } else {
                        $query->where(...$where);
                    }
                }
            }
            else if (!empty($search) && $field->isInSearch()) {
                $query->orWhere($field->getName(), "like", "%" . $search . "%");
            }
        }

        // TODO: add order by (id: default)
        $query->orderBy($tableName . ".id", "desc");

        if ($withPagination) {
            $paginatedList = $query->paginate();
            Utils::prepareModelData($paginatedList->getCollection());
            return $paginatedList;
        }

        return $query->get();
    }

    public static function getRecord($id) {
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
        $query->where($tableName .".id", "=", $id);

        $record = $query->get();

        if (!$record) {
            return null;
        }

        Utils::prepareModelData($record);
        return $record[0];
    }

    public static function saveRecord($data, $files = []) {
        $structure = static::getStructure();
        if (!$structure) {
            return null;
        }

        $requiredFields = [];
        foreach ($structure->getFields() as $field) {
            if ($field->isRequired()) {
                $requiredFields = [
                    ...$requiredFields,
                    $field->getName() => "required"
                ];
            }
        }

        $validator = Validator::make($data, $requiredFields);
        if ($validator->fails()) {
            return [
                "record" => false,
                "errors" => $validator->errors()
            ];
        }

        $validatedData = $validator->getData();

        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                $uploadedFile = File::uploadFile($file);
                if ($uploadedFile) {
                    $validatedData[$key] = $uploadedFile->id;
                }
            }
        }

        $record = static::query()->updateOrCreate(
            isset($validatedData["id"]) ? ["id" => $validatedData["id"]] : [],
            $validatedData
        );

        return [
            "record" => $record,
            "errors" => null
        ];
    }
}
