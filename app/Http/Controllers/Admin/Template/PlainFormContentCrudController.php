<?php

namespace App\Http\Controllers\Admin\Template;

use App\Http\Requests\PlainFormContentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlainFormContentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlainFormContentCrudController extends CrudController
{

    public function setup()
    {
        CRUD::setModel(\App\Models\Demo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plain-form-content');
        CRUD::setEntityNameStrings('plain form content', 'plain form contents');

        // Definir variables para la vista
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Plain Form Content';
        $this->data['subtitle'] = 'Plantilla CRUD';

        return view('app_web.plain_form_content', $this->data);
    }
    
}
