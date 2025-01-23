<?php

use App\Http\Controllers\Admin\Template\BaseCrudCrudController;
use App\Http\Controllers\Admin\Template\PlainDatabaseCrudController;
use Illuminate\Support\Facades\Route;

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!           RUTAS DE API                !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if(!function_exists('custom_api')) 
{
    function custom_api() 
    {
        
    }
}


// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!        RUTAS CON PREFIJO AMDIN        !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if(!function_exists('custom_admin')) 
{
    function custom_admin() 
    {
        Route::get('/base-crud', 
        [BaseCrudCrudController::class, 'setup'])
        ->name('templates.base.crud');

        Route::get('/plain-database', 
        [PlainDatabaseCrudController::class, 'setup'])
        ->name('templates.plain.database.crud');
    }
}


// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!           RUTA RAIZ                   !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if(!function_exists('route_root')) 
{
    function route_root() 
    {
        Route::get('/', function () {
            return redirect("/".config('backpack.base.route_prefix', 'admin'));
        });
           
    }
}

