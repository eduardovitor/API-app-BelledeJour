<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: DELETE");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once 'mongodb_config.php';

	$nome_banco = 'belledejour';
	$colecao = 'agendamentos';

	$bd = new DbManager();
	$conexao = $bd->getConnection();

	$dados = json_decode(file_get_contents("php://input", true));

	$filtro = ["email"=> $dados->email, "data_agendamento" => $dados->data_agendamento, "hora_agendamento" => $dados->hora_agendamento];
	$opcoes = [];
	$consulta = new MongoDB\Driver\Query($filtro, $opcoes);
	$registro_afetado= $conexao->executeQuery("$nome_banco.$colecao", $consulta)->toArray();
	$id=$registro_afetado[0]->_id;

	$deletar = new MongoDB\Driver\BulkWrite();
	$deletar->delete(
		['_id' => new MongoDB\BSON\ObjectId($id)],
		['limit' => 0]
	);

	$resultado = $conexao->executeBulkWrite("$nome_banco.$colecao", $deletar);

	if ($resultado->getDeletedCount() == 1) {
	    echo json_encode(
			array("status_code" => "200")
		);
	} else {
	    echo json_encode(
	            array("status_code" => "400")
	    );
	}

?>