<?php
include __DIR__."/src/Framework/Database.php";
use Framework\Database;
$db = new Database('mysql',[
    'hostname' => 'localhost',
    'port'=>3306,
    'dbname'=>'phpiggy'
],'root',''); //refactor the code
//echo "Connected to database";
//$search = "shirts' OR 1=1 -- ";//Create dynamic query -- is a sql comment in this condition show all record because '
/*try{
    $db->connection->beginTransaction();
    $db->connection->query("INSERT INTO products VALUES (3,'gloves')");//insert query only one time beacuse of transaction
    $search = "shirts";
    $query = "SELECT * FROM products WHERE name=:name"; //quering the database name=$search name=? name =:name
    $stmt = $db->connection->prepare($query); //prepare statement does not immidiately execute the query when query is immidiately execute
    $stmt->bindValue('name','gloves',PDO::PARAM_STR); //PARAM_STR -> use for check datatype
    $stmt->execute(); //using execute method run the query manually
    var_dump($stmt->fetchAll(PDO::FETCH_OBJ)); //FETCH_OBJ->give the array of object and each object the column name as a property
    $db->connection->commit();

}catch(Exception $error){
    if($db->connection->inTransaction()){//check connection in transaction or not
        $db->connection->rollBack();
    }
    echo "Transaction Failed";
}*/

/* $search = "shirts";
$query = "SELECT * FROM products WHERE name=:name"; //quering the database name=$search name=? name =:name
 //echo $query;
// $stmt = $db->connection->query($query,PDO::FETCH_ASSOC); //FETCH_NUM -> name key is disappear only numeric key is show //FETCH_ASSOC -> display output as associative array
 $stmt = $db->connection->prepare($query); //prepare statement does not immidiately execute the query when query is immidiately execute
 $stmt->bindValue('name',$search,PDO::PARAM_STR); //PARAM_STR -> use for check datatype
 $stmt->execute( //using execute method run the query manually
   //['name'=>$search]// ? character represent placeholder and it pass in array -> placeholder can be replaced in item of array
 );
 var_dump($stmt->fetchAll(PDO::FETCH_OBJ)); //FETCH_OBJ->give the array of object and each object the column name as a property*/

 $sqlFile = file_get_contents("./Database.sql");
 $db->query($sqlFile);