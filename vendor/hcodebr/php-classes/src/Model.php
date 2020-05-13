<?php 

namespace Hcode;

class Model{

	private $values = [];

	public function __call($name, $args){

		$method = substr($name, 0,3); // da posicão 0 traga os 3 primeiros caracteres
		$fieldName = substr($name,3,strlen($name)); // traga a string $name a partir da posição 3 até o final da string

		switch ($method) {
			case "get":
				return $this->values[$fieldName];

				break;
			case "set":
				$this->values[$fieldName] = $args[0];
				break;
			
		}

	}

	public function setData($data = array()) //criando um método que gera  um array de métodos que receberao o set(nome do campo) e o valor
	{
		foreach ($data as $key => $value) {
			$this->{"set".$key}($value);//criando um méotdo concatenando o a string SET com o nome do campo (idUser) retornado no banco de dados com o valor do campo $value
		}
	}

	public function getValues(){
		return $this->values;
	}
}






 ?>
