<?php
namespace App\Utils;

use \PDO;
use \PDOException;

class Database{

  private static $host;
  private static $name;
  private static $user;
  private static $password;
  private $table;
  private $connection;

  public function __construct($table,$host = '',$name = '',$user = '',$password = '' )  {
    $this->table = $table;
    $this->config($host,$name,$user,$password);
    $this->connect();
  }
  private function config($host,$name,$user,$password){
    self::$host = strlen($host) ? $host : getenv('DB_HOST');
    self::$name = strlen($name) ? $name : getenv('DB_NAME');
    self::$user = strlen($user) ? $user : getenv('DB_USER');
    self::$password = strlen($password) ? $password : getenv('DB_PASSWORD');
  }
  private function connect(){
    try {
      $this->connection = new PDO("pgsql:host=".self::$host.";dbname=".self::$name, self::$user, self::$password);

      //config pdo para lançar exceção caso ocorra erro
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {

      //logar esse erro futuramente
      die('ERROR: '.$e->getMessage());
    }
  }
  private function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  public function select($where = null, $order = null, $limit = null, $fields = '*'){
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

    return $this->execute($query);
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
  
  public function update($where,$values){
    $fields = array_keys($values);
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    $this->execute($query,array_values($values));
    return true;
  }

  public function delete($where){
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
    $this->execute($query);
    return true;
  }
}