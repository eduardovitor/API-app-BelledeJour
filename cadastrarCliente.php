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


	$inserir = new MongoDB\Driver\BulkWrite();
	$inserir->insert($dados);

	$resultado = $conexao->executeBulkWrite("$nome_banco.$colecao", $inserir);


	if ($resultado->getInsertedCount() == 1) {
	    echo json_encode(
			array("status_code" => "201")
		);
	} else {
	    echo json_encode(
	            array("status_code" => "404")
	    );
	}

?>
