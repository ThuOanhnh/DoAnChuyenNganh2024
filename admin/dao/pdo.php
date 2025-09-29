<?php
// Cấu hình thông tin kết nối cơ sở dữ liệu
define('DB_HOST', 'localhost'); // Địa chỉ máy chủ
define('DB_NAME', 'laptop'); // Tên cơ sở dữ liệu của bạn
define('DB_USER', 'root'); // Tên tài khoản database
define('DB_PASS', ''); // Mật khẩu tài khoản database

// Hàm kết nối đến cơ sở dữ liệu
function pdo_get_connection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Báo lỗi dưới dạng exception
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Trả kết quả dưới dạng mảng kết hợp
            PDO::ATTR_EMULATE_PREPARES => false, // Tắt giả lập prepared statements
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
    }
}

// Hàm thực hiện truy vấn SELECT một kết quả
function pdo_query_one($sql, ...$params) {
    $pdo = pdo_get_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(); // Lấy một dòng kết quả
    $pdo = null; // Đóng kết nối
    return $result;
}

// Hàm thực hiện truy vấn SELECT nhiều kết quả
function pdo_query($sql, ...$params) {
    $pdo = pdo_get_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(); // Lấy tất cả kết quả
    $pdo = null; // Đóng kết nối
    return $result;
}

// Hàm thực hiện câu lệnh thêm, sửa, xóa
function pdo_execute($sql, ...$params) {
    $pdo = pdo_get_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pdo = null; // Đóng kết nối
}

// Hàm thực hiện câu lệnh thêm mới và trả về ID vừa thêm
function pdo_execute_return_last_id($sql, ...$params) {
    $pdo = pdo_get_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $last_id = $pdo->lastInsertId();
    $pdo = null; // Đóng kết nối
    return $last_id;
}
?>
