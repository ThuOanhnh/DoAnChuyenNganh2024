<?php
function connectdb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    try{
        $conn = new PDO("mysql:host=$servername;dbname=laptop", $username, $password);
		$conn->query('set names utf8');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();

    }
    return $conn;
}
function selectSQL($sql){
    $conn=connectdb();
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn=null;
    return $result;
}


?>