<?php

namespace Modules\Vpanel\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function getInterface(Request $request): array
    {
        $moduleName = $request->get('module', '');
        $modelName = $request->get('model', '');

        $model = $this->getModel($moduleName, $modelName);
        if (!$model) {
            throw new \Error('Model not found!');
        }

        return [
            'interface' => $model->getStructure()->toArray(),
            'list' => $model->getList()
        ];
    }

    private function getModel($moduleName, $modelName): ?BaseModel
    {
        $modelClass = 'Modules\\' . $moduleName . '\\Entities\\' . ucfirst($modelName);
        if (!class_exists($modelClass)) {
            return null;
        }

        return new $modelClass();
    }
}