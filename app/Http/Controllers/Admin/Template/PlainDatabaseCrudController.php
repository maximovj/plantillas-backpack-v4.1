<?php

namespace App\Http\Controllers\Admin\Template;

use App\Http\Requests\PlainDatabaseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlainDatabaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlainDatabaseCrudController extends CrudController
{
  
    public function setup()
    {
        CRUD::setModel(\App\Models\Demo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plain-database');
        CRUD::setEntityNameStrings('plain database', 'plain databases');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Plantilla CRUD';
        $this->data['subtitle'] = 'Plain Database';

        return view('app_web.plain_databasejs', $this->data);
    }
   
}
