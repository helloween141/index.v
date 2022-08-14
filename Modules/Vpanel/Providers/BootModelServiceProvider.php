<?php

namespace Modules\Vpanel\Providers;

use Illuminate\Support\ServiceProvider;

class BootModelServiceProvider extends ServiceProvider
{

    /**
     * Создание таблиц по полям модели
     *
     * @return array
     */
    public function boot(): void
    {
        /*$modules = $this->app['modules']->all();
        foreach ($modules as $module) {
            $allModelsFiles = File::glob($module->getPath() . '/Entities/*.php');

            foreach ($allModelsFiles as $modelFile) {
                $fileName = pathinfo($modelFile, PATHINFO_FILENAME);
                $model = 'Modules\\' . $module->getName() . '\\Entities\\' . ucfirst($fileName);

                $fields = $model::getStructure()->getFields();
                foreach ($fields as $field) {

                }
            }
        }*/
    }

    private function checkStructure()
    {

    }
}
