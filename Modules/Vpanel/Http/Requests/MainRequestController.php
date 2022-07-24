<?php

namespace Modules\Vpanel\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Nwidart\Modules\Facades\Module;

class MainRequestController extends Controller
{
    public function getMenu(Response $response)
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

    public function getRecords() {

    }

    public function getInterface() {

    }
}