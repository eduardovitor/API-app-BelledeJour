<?php

class DbManager {

	private $bdhost = 'localhost';
	private $bdport = '27017';
	private $conexao;
	
	function __construct(){
        try {
            $this->conexao = new MongoDB\Driver\Manager('mongodb://'.$this->bdhost.':'.$this->bdport);
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }
    }

	function getConnection() {
		return $this->conexao;
	}

}

?>
