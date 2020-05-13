<?php 
namespace Hcode\Model;//definindo o name espace dessa classe
use \Hcode\DB\Sql;//usando o name space da classe Sql
use \Hcode\Model;
class User extends Model{//criando classe User

const SESSION = "User";
public static function login ($login, $password){//crianndo funcao que recebe as variaveis login e senha via post da pagina de login


	$sql = new Sql();//instanceando a classe slq do name space sql

	$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(//realizando um sql com o login recebido na funcao
		":LOGIN"=>$login

	));

	if (count($results)===0){//verificando o resultado do sql
		throw new \Exception("Usuário inexistente ou senha inválida.");//se nao achar nenhum login o sistema lanca uma exception
		

	}

	$data = $results[0];

	if (password_verify($password, $data["despassword"])===true){//verificando se o password é valido

		$user = new User(); //criando novo objeto
		$user->setData($data);

		$_SESSION[User::SESSION] = $user->getValues(); //colocando os dados od usuário na sessão

		return $user;

	}
	else {
		throw new \Exception("Usuário inexistente ou senha inválida."); //se a senha nao for igual sistema lança uma exception
		
	}
}
public static function verifyLogin($inadmin = true){


	if( !isset($_SESSION[User::SESSION])
	||
	!$_SESSION[User::SESSION]
	||
	!(int)$_SESSION[User::SESSION]["iduser"] >0
	||
	(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
	){
		header("Location: /admin/login");
		exit;
	}
}

public static function logout(){

		$_SESSION[User::SESSION] = NULL;
}

}


 ?>