<?php

namespace Modules\Vpanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Vpanel\Core\ApiError;
use Modules\Vpanel\Core\Utils;
use Nwidart\Modules\Facades\Module;

class MainRequestController extends Controller
{
    public function getMenu()
    {
        $list = [];
        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            $menu = $module->get('menu') ?? null;
            if ($menu) {
                $list[] = $menu;
            }
        }

        return response()->json($list,Response::HTTP_OK);
    }

    public function getInterface(string $moduleName, string $modelName)
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $structure = Utils::toArray($model::getStructure());
        return response()->json($structure, Response::HTTP_OK);
    }

    public function getList(string $moduleName = '', string $modelName = '')
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $list = $model::getList()
            ->paginate();

        return response()->json($list, Response::HTTP_OK);
    }

    public function getPointer(Request $request)
    {
        $model = $request->get('model');
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $records = $model::getList()->get();
        return response()->json($records, Response::HTTP_OK);
    }

    public function getRecord(string $moduleName, string $modelName, int $id = 0)
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        if ($id > 0) {
            $record = $model::find($id);
            return response()->json($record, $record ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_OK);
    }

    public function saveRecord(Request $request, string $moduleName, string $modelName)
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $requiredFields = $model::getStructure()->getRequiredFields();

        $validator = Validator::make($request->post(), $requiredFields);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        $record = $model::query()->updateOrCreate(
            ['id' => $validatedData['id'] ?? 0],
            $validatedData
        );

        return response()->json($record, $record ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function deleteRecord(string $moduleName, string $modelName, int $id)
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $result = $model::where('id', $id)->delete();

        return response()->json($result, $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
