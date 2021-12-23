<?php
namespace App\Db;

use \PDO;
use \PDOException;

class Database{

  const HOST = 'db';

  const NAME = 'technews';

  const USER= 'jedi';

  const PASSWORD = 'alfa';


  private $table;

  private $connection;

  public function __construct($table = null)  {
    $this->table = $table;
    $this->connect();
  }

  private function connect(){
    try {
      echo "Tentou";
      $this->connection = new PDO("pgsql:host=".self::HOST.";dbname=".self::NAME, self::USER, self::PASSWORD);
      echo '<pre>';
      print_r($this->connection);
      echo '</pre>';
      //config pdo para lançar exceção caso ocorra erro
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {

      //logar esse erro futuramente
      echo "Nem tentou";
      die('ERROR: '.$e);
    }
  }
}