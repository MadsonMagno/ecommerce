<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;



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

 ?>