<?php 
session_start();
//CONSTRUINDO A PAGINA INDEX
//CONSTRUTOR DE PAGINAS

require_once("vendor/autoload.php"); //TRAZENDO TODAS AS DEPENDENCIAS DO COMPPOSER

use \Slim\Slim; //USANDO CLASSES 
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;


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

$app->get('/admin/users', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
    User::verifyLogin();
    $users = User::listAll();
	$page = new PageAdmin(); //EXECUTA A FUNÇÃO PAGE
	$page->setTpl("users", array(
		"users"=>$users
	));//CARREGA O CONTEUDO NO TEMPLATE INDEX
});



$app->get('/admin/users/create', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    User::verifyLogin();
$page = new PageAdmin();

$page->setTpl("users-create");
exit;
});

$app->get('/admin/users/:iduser/delete', function ($iduser){
	User::verifyLogin();
	$user = new User();;
	$user->get((int)$iduser);
	
	$user->delete();
	header("Location: /admin/users");
	exit;
});


$app->get('/admin/users/:iduser', function($iduser) {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    User::verifyLogin();
    $user = new User;
    $user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(
			"user"=>$user->getValues()
	));
exit;
});

$app->post('/admin/users/create', function (){//recebe dados do formulario de criacao de email
	User::verifyLogin();
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	$user->save();

	header("Location: /admin/users");
	exit;


});

$app->post('/admin/users/:iduser', function ($iduser){
	User::verifyLogin();
	$user = new User();;
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();
	header("Location: /admin/users");
	exit;
});

$app->get('/admin/forgot', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new PageAdmin([
"header"=>false, //desabilitando o cabeçalho padrão
"footer"=>false//desabilitando o rodapé padrão
]); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("forgot");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});

$app->post('/admin/forgot', function (){
	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;

});

$app->get("/admin/forgot/sent", function(){
$page = new PageAdmin([
"header"=>false, //desabilitando o cabeçalho padrão
"footer"=>false//desabilitando o rodapé padrão
]); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("forgot-sent");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});


$app->get("/admin/forgot/reset", function(){

	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));

});

$app->post("/admin/forgot/reset", function(){

	$forgot = User::validForgotDecrypt($_POST["code"]);	

	User::setFogotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = User::getPasswordHash($_POST["password"]);

	$user->setPassword($password);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset-success");

});

$app->get("/admin/categories", function(){
	User::verifyLogin();
	$categories = Category::listAll();
	$page = new PageAdmin();
	$page->setTpl("categories",[
		'categories'=>$categories]);
});


$app->get("/admin/categories/create", function(){
	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
	User::verifyLogin();
	$category = new Category;
	$category->setData($_POST);
	$category->save();
	header("Location: /admin/categories");
	exit;
});


$app->get("/admin/categories/:idcategory/delete", function($idcategory){
	User::verifyLogin();
	$category = new Category;
	$category->get((int)$idcategory);
	$category->delete();
	header("Location: /admin/categories");
	exit;
});



$app->get("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	$category = new Category;
	$category->get((int)$idcategory);
$page = new PageAdmin();
	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);
});

$app->post("/admin/categories/:idcategory", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();	

	header('Location: /admin/categories');
	exit;

});
$app->run(); //APÓS TUDO CARREGADO, EXECUTA

 ?>