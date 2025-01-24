<?php

use App\Http\Controllers\Admin\Template\BaseCrudCrudController;
use App\Http\Controllers\Admin\Template\PlainDatabaseAdvancedCrudController;
use App\Http\Controllers\Admin\Template\PlainDatabaseCrudController;
use App\Http\Controllers\Admin\Template\PlainFormContentCrudController;
use Illuminate\Support\Facades\Route;

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!           RUTAS DE API                !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if(!function_exists('custom_api')) 
{
    function custom_api() 
    {

        Route::post('/plain-database-advanced', 
        [PlainDatabaseAdvancedCrudController::class, 'api_fetch'])
        ->name('api.templates.plain.database.advanced');
        
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

        Route::get('/plain-form-content', 
        [PlainFormContentCrudController::class, 'setup'])
        ->name('templates.plain.form.content.crud');

        Route::get('/plain-database-advanced', 
        [PlainDatabaseAdvancedCrudController::class, 'setup'])
        ->name('templates.plain.database.advanced');

        Route::group(['prefix' => '/api/v1'], function () {

            // !! Definir rutas de API con PREFIJO ADMIN

        });
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

