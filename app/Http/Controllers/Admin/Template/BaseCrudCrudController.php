<?php

namespace App\Http\Controllers\Admin\Template;

use App\Http\Requests\BaseCrudRequest;
use App\Http\Requests\DemoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BaseCrudCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BaseCrudCrudController extends CrudController
{
    
    public function setup()
    {
        CRUD::setModel(\App\Models\Demo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/base-crud');
        CRUD::setEntityNameStrings('base crud', 'base cruds');

        // Definir variables para la vista
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Plantilla CRUD';
        $this->data['subtitle'] = 'BaseCrud';

        return view('app_web.base_crud', $this->data);
    }
   
}
