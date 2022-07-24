<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    /**
     * @param Request $request
     * @param String $modelName
     * @return array|mixed
     */
    public function getSidebar(Request $request, string $modelName = ''): mixed
    {
        $Model = $this->getModelClass($modelName);
        $Resource = $this->getResourceClass($modelName . 'SidebarResource');

        if (!class_exists($Model) || !class_exists($Resource)) {
            return [
                'success' => 'false'
            ];
        }

        // TODO: apply filters

        $list = $Model::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        return $Resource::collection($list)->additional(
            [
                'headers' => $this->getSidebarFields($Model::getFields()) ?? [],
                'url' => $Model::$sidebarUrl ?? '',
                'title' => $Model::$sidebarTitle ?? ''
            ]
        );
    }

    public function getInterface(Request $request, string $modelName = ''): ?array
    {
        $model = $this->getModelClass($modelName);

        if (!class_exists($model)) {
            return [
                'success' => 'false'
            ];
        }

        return [
            'fields' => $model::getFields(),
            'detail_title' => $model::$detailTitle ?? '',
            'accusative_detail_title' => $model::$accusativeDetailTitle ?? ''
        ];
    }

    public function getData(Request $request, string $modelName = '', int $recordId = 0)
    {
        $model = $this->getModelClass($modelName);
        $resource = $this->getResourceClass($modelName . 'Resource');

        if (!class_exists($model) || !class_exists($resource)) {
            return [
                'success' => 'false'
            ];
        }

        $data = $model::query()
            ->where('id', $recordId)
            ->get();

        return $resource::collection($data);
    }

    public function saveData(Request $request, string $modelName = ''): ?array
    {
        $Model = $this->getModelClass($modelName);

        if (!class_exists($Model)) {
            return [
                'success' => 'false'
            ];
        }

        $id = (int) $request->post('id', 0);

        $requiredFields = $this->getRequiredFields($Model::getFields());
        $validatedData = $request->validate($requiredFields);

        $saveResult = $Model::query()->updateOrCreate(
            ['id' => $id],
            $validatedData
        );

        return [
            'id' => $saveResult->id
        ];
    }

    // TODO: return type ?array. Fix after debounce
    public function getSearchResult(Request $request, string $modelName = ''): mixed
    {
        $model = $this->getModelClass($modelName);
        $resource = $this->getResourceClass($modelName . 'Resource');

        if (!class_exists($model) || !class_exists($resource)) {
            return [
                'success' => 'false'
            ];
        }

        $searchString = trim($request->get('search_string', ''));
        if ($searchString) {
            $resultSearch = $model::query()
                ->where('name', 'LIKE', "%{$searchString}%")
                ->get();

            return $resource::collection($resultSearch);
        }

        return [];
    }

    private function getRequiredFields($fields): array
    {
        $result = [];
        foreach ($fields as $field) {
            if (isset($field['required'])) {
                $result = [...$result, $field['name'] => 'required'];
            }
        }
        return $result;
    }

    private function getSidebarFields($fields): array
    {
        $result = [];
        foreach ($fields as $field) {
            if (isset($field['show_in_sidebar'])) {
                $result = [...$result, $field['name'] => $field['title']];
            }
        }
        return $result;
    }

    private function getModelClass($name): string
    {
        return 'App\\Models\\' . ucfirst($name);
    }

    private function getResourceClass($name): string
    {
        return 'App\\Http\\Resources\\' . ucfirst($name);
    }
}
