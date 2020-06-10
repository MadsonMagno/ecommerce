<?php 
use \Hcode\Page;
 
$app->get('/', function() {//QUANDO CHAMAR VIA GET A PASTA RAIZ USA AS SEGUINTES FUNÇÕES
    
$page = new Page(); //EXECUTA A FUNÇÃO PAGE
$page->setTpl("index");//CARREGA O CONTEUDO NO TEMPLATE INDEX
});
 ?>