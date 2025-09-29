<?php
function connectdb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
   // $database = "laptop";

  
    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=laptop", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected Successfully";
        
    }
    catch(PDOException $e){
        // echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}


// function selectSQl($sql){
//     $conn=connectdb();
//     $stmt=$conn->prepare($sql);
//     $stmt->execute();
//     $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
//     $conn=null;
//     return $result;
// }

function selectSQL($sql, $params = []) {
    $conn = connectdb();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


function execSQL($sql, $params = []) {
    $conn = connectdb(); // Lấy kết nối cơ sở dữ liệu
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute($params);
    $conn = null; // Đóng kết nối sau khi thực thi
    return $result;
}


?>