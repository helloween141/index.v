<?php

namespace Modules\Vpanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Vpanel\Core\ApiError;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Utils;
use Nwidart\Modules\Facades\Module;

class MainRequestController extends Controller
{
    public function getMenu(): JsonResponse
    {
        $list = [];
        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            $menu = $module->get('menu') ?? null;
            if ($menu) {
                $list[] = $menu;
            }
        }
        return response()->json($list, Response::HTTP_OK);
    }

    public function getInterface(string $moduleName, string $modelName): JsonResponse
    {
        /** @var $model BaseModel */
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $structure = Utils::toArray($model::getStructure());
        return response()->json($structure, Response::HTTP_OK);
    }

    public function getList(Request $request, string $moduleName = '', string $modelName = ''): JsonResponse
    {
        /** @var $model BaseModel */
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $filter = json_decode($request->get('filter', []), true);
        $search = $request->get('search', '');
        $page = $request->get('page');

        $list = $model::getList(
            params: [
                'page' => $page,
                'filter' => $filter,
                'search' => $search,
            ]);

        return response()->json($list, Response::HTTP_OK);
    }

    public function getRecord(string $moduleName, string $modelName, int $id = 0): JsonResponse
    {
        /** @var $model BaseModel */
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        if ($id > 0) {
            $record = $model::getRecord($id);
            return response()->json($record, $record ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_OK);
    }

    public function saveRecord(Request $request, string $moduleName, string $modelName, int $id = 0): JsonResponse
    {
        /** @var $model BaseModel */
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $data = $request->all();
        $files = $request->file();

        $result = $model::saveRecord($data, $id, $files);
        if ($result['error']) {
            return response()->json($result['error'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json($result, $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function deleteRecord(string $moduleName, string $modelName, int $id): JsonResponse
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        /** @var $model BaseModel */
        $result = $model::where('id', $id)->delete();

        return response()->json($result, $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function sortList(Request $request, string $moduleName, string $modelName) {
        /** @var $model BaseModel */
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $data = $request->post('data', []);

        $model::sortList($data);

        return response()->json(true, Response::HTTP_OK);
    }
}
