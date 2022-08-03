<?php

namespace Modules\Vpanel\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Vpanel\Core\BaseModel;
use Nwidart\Modules\Facades\Module;

class MainRequestController extends Controller
{
    public function getMenu(): array
    {
        $list = [];
        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            $menu = $module->get('menu') ?? null;
            if ($menu) {
                $list[] = $menu;
            }
        }
        return $list;
    }

    public function getInterface(string $moduleName, string $modelName): array
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            return [];
        }

        return ($model::getStructure())->toArray();
    }

    public function getList(string $moduleName, string $modelName)
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            return [];
        }

        return $model::getList();
    }

    public function getRecord(string $moduleName, string $modelName, int $id = 0)
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            return [];
        }

        return $model::getRecord($id);
    }

    public function saveRecord(Request $request, string $moduleName, string $modelName) {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            return [];
        }

        $validator = Validator::make($request->post(), $model::getStructure()->getRequiredFields());

        if ($validator->fails()) {
            return $validator->errors();
        }

        $validatedData = $validator->getData();

        $record = $model::query()->updateOrCreate(
            ['id' => $validatedData['id'] ?? 0],
            $validatedData
        );

        return [
            'id' => $record->id
        ];
    }

    public function deleteRecord(string $moduleName, string $modelName, int $id)
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            return [];
        }

        $result = $model::where('id', $id)->delete();
        if (!$result) {
            throw new \Error('Запись не найдена!');
        }

        return [
            'success' => true
        ];
    }
}