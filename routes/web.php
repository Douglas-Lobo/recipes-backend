<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/



$router->group(['prefix' => '/api/v1/'], function() use ($router){

    $router->group(['namespace' => 'Auth'], function() use ($router){
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('me', 'AuthController@me');
    });

    $router->group(['middleware' => 'auth'], function() use ($router){

        $router->group(['prefix' => 'users'], function() use ($router){
            $router->get("/", "UsersController@index");
            $router->get("/{id}", "UsersController@show");
            $router->post("/", "UsersController@store");
            $router->post("/{id}", "UsersController@update");
            $router->delete("/{id}", "UsersController@destroy");
        });
        $router->group(['prefix' => 'recipes'], function() use ($router){
            $router->post("/related-categories", "RecipesController@relatedCategories");
            $router->get("/", "RecipesController@index");
            $router->get("/{id}", "RecipesController@show");
            $router->post("/", "RecipesController@store");
            $router->post("/{id}", "RecipesController@update");
            $router->delete("/{id}", "RecipesController@destroy");
        });

        $router->group(['prefix' => 'categories'], function() use ($router){
            $router->get("/", "CategoriesController@index");
            $router->get("/{id}", "CategoriesController@show");
            $router->post("/", "CategoriesController@store");
            $router->post("/{id}", "CategoriesController@update");
            $router->delete("/{id}", "CategoriesController@destroy");
        });

        $router->group(['prefix' => 'recipe_photos'], function() use ($router){
            $router->post("/{id}", "PhotosController@update");
            $router->delete("/{id}", "PhotosController@destroy");
        });
        $router->group(['prefix' => 'user_photo'], function() use ($router){
            $router->post("/{id}", "UserPhotoController@update");
            $router->delete("/{id}", "UserPhotoController@destroy");
        });

    });

});
