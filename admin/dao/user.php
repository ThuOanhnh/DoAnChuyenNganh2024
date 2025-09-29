<?php
include_once "pdo.php";

function checkuser($username, $password) {
    $sql = "SELECT * FROM nguoidung WHERE ten_nguoi_dung = ? AND mat_khau = ?";
    return pdo_query_one($sql, $username, $password);
   
}