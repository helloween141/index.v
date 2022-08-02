<?php

namespace Modules\Vpanel\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class BootModelServiceProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot(): void
    {
        $modules = $this->app['modules']->all();
        foreach ($modules as $module) {
            /** @var File $allFiles */
            $allFiles = File::glob($module->getPath() . '/Entities/*.php');

            foreach ($allFiles as $entity) {
                $model = pathinfo($entity, PATHINFO_FILENAME);
                $modelClass = 'Modules\\' . $module->getName() . '\\Entities\\' . ucfirst($model);

                if (method_exists($modelClass, 'setStructure')) {
                    $modelClass::setStructure();
                    $structure = $modelClass::getStructure();
                    if (isset($structure->fields)) {
                        foreach ($structure->fields as $field) {
                            if ($field->required) {
                                $modelClass::$requiredFields = [
                                    ...$modelClass::$requiredFields,
                                    $field->name => 'required'
                                ];
                            }
                        }
                    }
                }
            }
        }
    }

    private function callEntities() {

    }
}
