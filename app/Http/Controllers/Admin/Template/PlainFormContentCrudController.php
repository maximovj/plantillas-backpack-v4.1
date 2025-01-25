<?php

namespace App\Http\Controllers\Admin\Template;

use App\Http\Requests\PlainFormContentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

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

    public function api_fetch(Request $request) 
    {
        $request->validate([
            'field_1_val' => 'required|string|min:3',
            'file_excel' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $formData = collect($request->all());
        $file_excel = $request->file('file_excel');

        return response()->json([
            'type' => 'success',
            'title' => 'Plain Form Content',
            'message' => 'Datos recibidos del formulario correctamente',
            'data' => [
                'formData' => $formData,
                'file_excel' => [
                    'nombre_original' => $file_excel->getClientOriginalName(),
                    'extension' => $file_excel->getClientOriginalExtension(),
                    'tipo_mime' => $file_excel->getMimeType(),
                    'tamanio' => $file_excel->getSize(),
                ],
            ],
        ], 200);
    }
    
}
