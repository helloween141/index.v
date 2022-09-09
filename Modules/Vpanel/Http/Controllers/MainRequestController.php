<?php

namespace Modules\Vpanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\File\Entities\File;
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
            $menu = $module->get("menu") ?? null;
            if ($menu) {
                $list[] = $menu;
            }
        }
        return response()->json($list,Response::HTTP_OK);
    }

    public function getInterface(string $moduleName, string $modelName): JsonResponse
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $structure = Utils::toArray($model::getStructure());
        return response()->json($structure, Response::HTTP_OK);
    }

    public function getList(Request $request, string $moduleName = "", string $modelName = ""): JsonResponse
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        $withPagination = !(($request->get("pagination")) === "false");
        $filter = json_decode($request->get("filter", []), true);
        $search = $request->get("search", "");

        /** @var $model BaseModel */
        $list = $model::getList(filter: $filter, search: $search, withPagination: $withPagination);

        return response()->json($list, Response::HTTP_OK);
    }

    public function getRecord(string $moduleName, string $modelName, int $id = 0): JsonResponse
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

    public function saveRecord(Request $request, string $moduleName, string $modelName): JsonResponse
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        /** @var $model BaseModel */
        $requiredFields = $model::getStructure()->getRequiredFields();

        $validator = Validator::make($request->all(), $requiredFields);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        $files = $request->file();
        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                $uploadedFile = File::uploadFile($file);
                if ($uploadedFile) {
                    $validatedData[$key] = $uploadedFile->id;
                }
            }
        }

        $record = $model::query()->updateOrCreate(
            ["id" => $validatedData["id"] ?? 0],
            $validatedData
        );

        return response()->json($record, $record ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function deleteRecord(string $moduleName, string $modelName, int $id): JsonResponse
    {
        $model = Utils::getModelClass($moduleName, $modelName);
        if (!class_exists($model)) {
            throw new \Error(ApiError::MODEL_NOT_FOUND);
        }

        /** @var $model BaseModel */
        $result = $model::where("id", $id)->delete();

        return response()->json($result, $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
