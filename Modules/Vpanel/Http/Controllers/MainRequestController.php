<?php

namespace Modules\Vpanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Vpanel\Core\Utils;
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
            throw new \Error('Модель не найдена!');
        }

        return Utils::toArray($model::getStructure());
    }

    public function getList(Request $request, string $moduleName = '', string $modelName = '')
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);

        if (!class_exists($model)) {
            throw new \Error('Модель не найдена!');
        }

        return $model::getList();
    }

    public function getPointer(Request $request)
    {
        $model = $request->get('model');

        if (!class_exists($model)) {
            throw new \Error('Модель не найдена!');
        }

        return $model::all();
    }

    public function getRecord(string $moduleName, string $modelName, int $id = 0)
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            throw new \Error('Модель не найдена!');
        }

        return $model::find($id);
    }

    public function saveRecord(Request $request, string $moduleName, string $modelName)
    {
        $model = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($model)) {
            throw new \Error('Модель не найдена!');
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
            throw new \Error('Модель не найдена!');
        }

        $result = $model::where('id', $id)->delete();

        return [
            'success' => $result
        ];
    }
}