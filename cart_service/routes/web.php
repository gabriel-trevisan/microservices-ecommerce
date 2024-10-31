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

$router->group(['prefix' => 'cart'], function () use ($router) {
    $router->post('/{customerId}', 'CartController@create');
    $router->post('/{cartId}/items', 'CartController@addItem');
    $router->delete('/{cartId}/items/{itemId}', 'CartController@removeItem');
    $router->get('/{cartId}/items', 'CartController@viewItems');
    $router->put('/{cartId}/items/{itemId}/quantity', 'CartController@updateQuantity');
});