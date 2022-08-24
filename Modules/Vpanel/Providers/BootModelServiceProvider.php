<?php

namespace Modules\Vpanel\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Modules\Vpanel\Core\Utils;

class BootModelServiceProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot(): void
    {
//        $modules = $this->app['modules']->all();
//        foreach ($modules as $module) {
//            /** @var File $allFiles */
//            $allFiles = File::glob($module->getPath() . '/Entities/*.php');
//
//            foreach ($allFiles as $entity) {
//                $model = pathinfo($entity, PATHINFO_FILENAME);
//                $modelClass = Utils::getModelClass($module->getName(), $model);
//
//                if (method_exists($modelClass, 'setStructure')) {
//                   // $modelClass::defineStructure();
//                }
//            }
//        }
    }
}
