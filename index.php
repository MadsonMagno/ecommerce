<?php 
session_start();
//CONSTRUINDO A PAGINA INDEX
//CONSTRUTOR DE PAGINAS

require_once("vendor/autoload.php"); //TRAZENDO TODAS AS DEPENDENCIAS DO COMPPOSER

use \Slim\Slim; //USANDO CLASSES 
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;


$app = new Slim(); //UTILIZANDO A CLASSE DE ROTAS

$app->config('debug', true);

$app->get('/', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new Page(); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("index");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});

$app->get('/admin', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    User::verifyLogin();
$page = new PageAdmin(); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("index");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});

$app->get('/admin/login', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new PageAdmin([
"header"=>false, //desabilitando o cabeçalho padrão
"footer"=>false//desabilitando o rodapé padrão
]); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("login");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});

$app->post('/admin/login', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
User::login($_POST["login"], $_POST["password"]);

header("Location: /admin");
exit;
});

$app->get('/admin/logout', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
User::logout();

header("Location: /admin/login");
exit;
});

$app->run(); //APÓS TUDO CARREGADO, EXECUTA

 ?>