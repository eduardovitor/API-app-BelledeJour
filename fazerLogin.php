<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'mongodb_config.php';

	$nome_banco = 'belledejour';
	$colecao = 'cliente';


	$bd = new DbManager();
	$conexao = $bd->getConnection();

	$dados = json_decode(file_get_contents("php://input", true));

	$filtro = ["email"=> $dados->email, "senha" => $dados->senha];
	$opcoes = [];
	$consulta = new MongoDB\Driver\Query($filtro, $opcoes);

	$registros_afetados = $conexao->executeQuery("$nome_banco.$colecao", $consulta)->toArray();


	if(count($registros_afetados)>0){
		echo json_encode(
			array("status_code" => "200")
		);
	}
	else{
		echo json_encode(
			array("status_code" => "404")
		);
	}


?>
