<?php 
session_start();
//CONSTRUINDO A PAGINA INDEX
//CONSTRUTOR DE PAGINAS

require_once("vendor/autoload.php"); //TRAZENDO TODAS AS DEPENDENCIAS DO COMPPOSER

use \Slim\Slim; //USANDO CLASSES 



$app = new Slim(); //UTILIZANDO A CLASSE DE ROTAS

$app->config('debug', true);
require_once("functions.php");
require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");
require_once("admin-orders.php");




$app->run(); //APÓS TUDO CARREGADO, EXECUTA

 ?>