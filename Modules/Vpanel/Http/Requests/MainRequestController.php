<?php

namespace Modules\Vpanel\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function getInterface(Request $request) {
        $moduleName = $request->get('module', '');
        $modelName = $request->get('model', '');
        if (!$moduleName || !$modelName) {
            return [];
        }

        $model = $this->getModelClass($moduleName, $modelName);

        if (!class_exists($model)) {
            return [
                'success' => 'false'
            ];
        }

        return [
            'structure' => $model->getStructure(),
            'list' => $model->getAll()
        ];
    }

    public function getList(Request $request) {

    }

    private function getModelClass($moduleName, $modelName): string
    {
        return 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
    }
}