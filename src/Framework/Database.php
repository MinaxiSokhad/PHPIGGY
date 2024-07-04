<?php 
declare(strict_types=1);
namespace Framework;
use PDO,PDOException,PDOStatement;
class Database{
    private PDO $connection;
    private PDOStatement $stmt;
    public function __construct(
        string $driver,
        array $config,
        string $username,
        string $password)
     {
       
         $config = http_build_query(data: $config
        // ['host' => 'localhost','port' => 3306, 'dbname' => 'phpiggy']
            ,arg_separator:';');

         $dsn = "{$driver}:{$config}";//create DSN string for database with ; separator
             
         //$username = 'root';
             //$password = '';
         try{
             $this->connection = new PDO($dsn,$username,$password,[
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
             ]);
            }catch(PDOException $e){
             die("Unable to connect database");
       }
 }
 public function query(string $query,array $params=[]):Database
 {
   // $this->connection->query($query); //use private variable and direct access query method for run the query
   $this->stmt = $this->connection->prepare($query); //use prepare statement for run the query and also add user service
   $this->stmt->execute($params);
   return $this;
 }
 public function count(){
    return $this->stmt->fetchColumn();
 }
 public function find(){
    return $this->stmt->fetch();
 }
 public function id(){
    return $this->connection->lastInsertId();
 }
}