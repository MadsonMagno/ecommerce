<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;


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


 ?>