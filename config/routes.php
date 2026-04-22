<?php

/**
 * @param $router \Core\Router
 * @return void
 */
return function (\Core\Router $router): void {

    $router->get('/', 'CategoryController@index');

    $router->get('/category/{id:\d+}', 'CategoryController@view');

    $router->get('/article/{id:\d+}', 'ArticleController@view');

};