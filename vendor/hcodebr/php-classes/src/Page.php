<?php 
namespace Hcode; //especificando o name espace onde essa classe está
use  Rain\Tpl; //chamando a função tpl do namespace Rain

class Page{
	private $tpl;//criando a variavel tpl
	private $options = [];
	private $defaults = [
		"data"=>[]];
	public function __construct($opts = array()){//deve ser o primeiro a ser exexcutado //recebe opções via array

		$this->options = array_merge($this->defaults, $opts); //mesclando os arrays $defaults e $opts com array merge e jogando em $options, $opts vai sobrescrever o array $defaults
		//configurando template
$config = array(
					"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",//pasta que busca os arquivos html
					"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",//pasta que busca os arquivos html
					"debug"         => false // set to false to improve the speed
				   );

	Tpl::configure( $config ); //tpl recebe as configurações acima

	// create the Tpl object
	$this->tpl = new Tpl; //transformando a variavel $tpl com atributo da classe com o $this

	$this->setData($this->options["data"] );//chamando a funcção setData pra ser execccutada com os dados da variável $options

	$this->tpl->draw("header"); //desenhando arquivo header que ira montar o cabeçalho html que se repete pra todas as paginas


	}

	private function setData($data=array()){
		foreach ($data as $key => $value) {//pra cada opção dentro da variável $data recebida pela função
		$this->tpl->assing($key,$value);//tpl recebe nome e valor da variavel passada para o template na variavel $data que é um array	


	}
	}

public function setTpl ($name, $data = array(), $returnHtml = false){

	$this->setData($data); //associando valor e chave das variaveis passada em $data

	return $this->tpl->draw($name, $returnHtml); //criando um template com o nome passado na variável $name e $returnHtml


}
	public function __destruct(){//deve ser o ultimo a ser executado

		$this->tpl->draw("footer");//desenhando arquivo footer que ira montar o rodapé html que se repete pra todas as paginas


	}
}



 ?>