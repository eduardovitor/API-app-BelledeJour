<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once 'mongodb_config.php';

$nome_banco = 'belledejour';
$colecao = 'agendamentos';



$bd = new DbManager();
$conexao = $bd->getConnection();

$dados = json_decode(file_get_contents("php://input", true));


$filtro = ["email" => $dados->email];
$opcoes = [];
$consulta = new MongoDB\Driver\Query($filtro, $opcoes);


$registros_afetados = $conexao->executeQuery("$nome_banco.$colecao", $consulta);

echo json_encode(iterator_to_array($registros_afetados));

?>