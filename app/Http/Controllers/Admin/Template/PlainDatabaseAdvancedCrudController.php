<?php

namespace App\Http\Controllers\Admin\Template;

use App\Http\Requests\PlainDatabaseAdvancedRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PlainDatabaseAdvancedCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlainDatabaseAdvancedCrudController extends CrudController
{

    public function setup()
    {
        CRUD::setModel(\App\Models\Demo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plain-database-advanced');
        CRUD::setEntityNameStrings('plain database advanced', 'plain database advanced');

        // Define environments for the views
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Plain Database Advanced';
        $this->data['subtitle'] = 'Plantilla CRUD';
        $this->data['dataRecords'] = [
            ['id' => 1,     'nombre' => 'Víctor R.',        'sexo' => 'hombre',     'hobbie' => 'codear',           'profesion' => 'fullstack',     'pais' => 'mexico'],
            ['id' => 2,     'nombre' => 'Rafel P.',         'sexo' => 'hombre',     'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 3,     'nombre' => 'Ricardo F.',       'sexo' => 'hombre',     'hobbie' => 'lectura',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 4,     'nombre' => 'Maria R.',         'sexo' => 'mujer',      'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 5,     'nombre' => 'Lepe G.',          'sexo' => 'mujer',      'hobbie' => 'codear',           'profesion' => 'backend',       'pais' => 'andorra'],
            ['id' => 6,     'nombre' => 'Carles T.',        'sexo' => 'hombre',     'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'mexico'],
            ['id' => 7,     'nombre' => 'Merie H.',         'sexo' => 'mujer',      'hobbie' => 'lectura',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 8,     'nombre' => 'Junio P',          'sexo' => 'hombre',     'hobbie' => 'codear',           'profesion' => 'frontend',      'pais' => 'egipto'],
            ['id' => 9,     'nombre' => 'Agoust R.',        'sexo' => 'hombre',     'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 10,    'nombre' => 'Petra L.',         'sexo' => 'mujer',      'hobbie' => 'codear',           'profesion' => 'pm',            'pais' => 'japon'],
            ['id' => 11,    'nombre' => 'Saul G.',          'sexo' => 'hombre',     'hobbie' => 'codear',           'profesion' => 'fullstack',     'pais' => 'mexico'],
            ['id' => 12,    'nombre' => 'Fredddy B.',       'sexo' => 'hombre',     'hobbie' => 'ejercicio',        'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 13,    'nombre' => 'Josh L.',          'sexo' => 'hombre',     'hobbie' => 'lectura',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 14,    'nombre' => 'Karla D.',         'sexo' => 'mujer',      'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'mexico'],
            ['id' => 15,    'nombre' => 'Lepe F.',          'sexo' => 'mujer',      'hobbie' => 'codear',           'profesion' => 'backend',       'pais' => 'andorra'],
            ['id' => 16,    'nombre' => 'Paola G.',         'sexo' => 'hombre',     'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 17,    'nombre' => 'Meravi H.',        'sexo' => 'mujer',      'hobbie' => 'ninguno',          'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 18,    'nombre' => 'Fabio P',          'sexo' => 'hombre',     'hobbie' => 'codear',           'profesion' => 'frontend',      'pais' => 'egipto'],
            ['id' => 19,    'nombre' => 'Joel R.',          'sexo' => 'hombre',     'hobbie' => 'videojuegos',      'profesion' => 'ninguno',       'pais' => 'ninguno'],
            ['id' => 20,    'nombre' => 'Levi L.',          'sexo' => 'mujer',      'hobbie' => 'codear',           'profesion' => 'pm',            'pais' => 'japon'],
        ];

        return view('app_web.plain_databasejs_advanced', $this->data);
    }

    public function api_fetch(Request $request)
    {
        $tableData = collect(json_decode($request->input('tableData'), true));

        return response()->json([
            'title' => 'Plain Database Advanced',
            'messsge' => 'Catálogo de cuentas se ha guardo correctamente',
            'data' => [
                'tableData_first' => $tableData->first(),
                'tableData_last' => $tableData->last(),
                'tableData_take' => $tableData->take(5),
                'tableData_sum' => $tableData->sum('id'),
                'tableData_isEmpty' => $tableData->isEmpty(),
                'tableData_filter' => $tableData->filter(fn($registro) => $registro['sexo'] === 'hombre'),
                'tableData_contains' => $tableData->contains('pais', 'japon'),
                'tableData_whereIn' => $tableData->whereIn('pais', ['mexico', 'japon']),
                'tableData_where_like' => $tableData->where('nombre', 'like', '%F.%'),
                'tableData_where' => $tableData->where('pais', 'mexico'),
                'tableData_pluck' => $tableData->pluck('pais'),
                'tableData_unique' => $tableData->unique(),
                'tableData_groupBy' => $tableData->groupBy('profesion'),
                'tableData_countBy' => $tableData->countBy('sexo'),
                'tableData_groupBy_toArray' => $tableData->groupBy('pais')->toArray(),
                'tableData_pluck_unique_values_toArray' => $tableData->pluck('pais')->unique()->values()->toArray(),
                'tableData_groupBy_map_toArray' => $tableData->groupBy('profesion')->map(fn($grupo) => $grupo->count())->toArray(),
                'tableData_groupBy_map_x3_toArray' => $tableData->groupBy('pais')->map(function ($grupoPorPais) {
                    return $grupoPorPais->groupBy('profesion') // Agrupa por profesión dentro de cada país
                            ->map(function ($grupoPorProfesion) {
                                return $grupoPorProfesion->groupBy('sexo'); // Agrupa por sexo dentro de cada profesión
                            });
                })->toArray(),
            ]
        ], 200);
    }

}
