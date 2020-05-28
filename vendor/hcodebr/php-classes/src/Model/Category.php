<?php 
namespace Hcode\Model;//definindo o name espace dessa classe
use \Hcode\DB\Sql;//usando o name space da classe Sql
use \Hcode\Model;
use \Hcode\Mailer;

class Category  extends Model{//criando classe User

public static function listAll(){

	$sql = new Sql();
	return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
}

public function save(){

	$sql= new Sql();
	$results = $sql->select("CALL `db_ecommerce`.`sp_categories_save`(:idcategory , :descategory)", 
		array(
		":idcategory"=>$this->getidcategory(),
		":descategory"=>$this->getdescategory()
		

	));

	$this->setData($results[0]);

}

public  function get($idcategory){

	$sql= new Sql();

	$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", 
		[':idcategory'=>$idcategory]);

	$this->setData($results[0]);
}

public function delete(){
	$sql = new Sql;

	$sql->query("DELETE FROM tb_categories where idcategory = :idcategory", [
		":idcategory"=>$this->getidcategory()]
	);
}
}


 ?>