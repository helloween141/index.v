<?php

namespace Modules\Vpanel\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;
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
        $model = $this->getModel($moduleName, $modelName);
        if (!$model) {
            throw new \Error('Model not found!');
        }

        $structure = ($model::getStructure())->toArray();

        return $structure;
    }

    public function getData(string $moduleName, string $modelName, int $recordId = null)
    {
        $model = $this->getModel($moduleName, $modelName);
        if (!$model) {
            throw new \Error('Model not found!');
        }

        $data = $model::getData($recordId);

        return $data;
    }

    public function saveData(Request $request, $moduleName, $modelName) {
        $model = $this->getModel($moduleName, $modelName);
        if (!$model) {
            throw new \Error('Model not found!');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->post(), $model::$requiredFields);

        if ($validator->fails()) {
            return ['error' => true];
        }

        $validatedData = $request->post();

        $saveResult = $model::query()->updateOrCreate(
            ['id' => (int) $validatedData['id']],
            $validatedData
        );

        return [
            'id' => $saveResult->id
        ];
    }

    private function getModel($moduleName, $modelName): ?string
    {
        $modelClass = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($modelClass)) {
            return null;
        }

        return $modelClass;
    }
}