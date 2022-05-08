<?php

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

//Controllers
$router->namespace("App\Http");

//Chamada do controller WebController, método home
$router->group(null);
$router->get("/", "WebController:home");
$router->get("/search/{search}", "WebController:find");
$router->post("/", "WebController:store");
$router->put("/{id}", "WebController:update");
$router->delete("/{id}", "WebController:delete");

//Erros
$router->group("erro");
$router->get("/{errcode}", "WebController:error");

//Disparo do router
$router->dispatch();

//Tratamento de erros de parametro de url
if($router->error()){
    $router->redirect("/erro/{$router->error()}");
}