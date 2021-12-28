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
      $this->connection = new PDO("pgsql:host=".self::HOST.";dbname=".self::NAME, self::USER, self::PASSWORD);

      //config pdo para lançar exceção caso ocorra erro
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {

      //logar esse erro futuramente
      die('ERROR: '.$e->getMessage());
    }
  }
  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }


  public function insert($values){
    $fields = array_keys($values);
    $inter = array_map(function($field){
      return '?';
    },$fields);

    $query = 'INSERT INTO '.$this->table.'('.implode(',',$fields).') VALUES ('.implode(',',$inter).')';
    $this->execute($query,array_values($values));
    return $this->connection->lastInsertId();
  }


  public function select($id = null){
    $condition = !is_null($id) ? ' WHERE news_id = ?' : '';
    echo '<pre>';
    print_r($condition);
    echo '</pre>';
    $query = 'SELECT * FROM '.$this->table.' '.$condition;
    echo '<pre>';
    print_r($query);
    echo '</pre>';
    return $this->execute($query,$id ? [$id] : []);
  }
}