<?php 

//CONSTRUINDO A PAGINA INDEX
//CONSTRUTOR DE PAGINAS

require_once("vendor/autoload.php"); //TRAZENDO TODAS AS DEPENDENCIAS DO COMPPOSER

use \Slim\Slim; //USANDO CLASSES 
use \Hcode\Page;
use \Hcode\PageAdmin;


$app = new Slim(); //UTILIZANDO A CLASSE DE ROTAS

$app->config('debug', true);

$app->get('/', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new Page(); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("index");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});

$app->get('/admin', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new PageAdmin(); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("index");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});


$app->run(); //APÓS TUDO CARREGADO, EXECUTA

 ?>