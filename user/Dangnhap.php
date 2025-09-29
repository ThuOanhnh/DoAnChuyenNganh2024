<?php
include '../connect.php';
$conn = connectdb();
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center ">
            ĐĂNG NHẬP
        </h2>
        <div class="row d-flex aligh-item-center justify-content-center mt-5">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- username -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Tên người dùng</label>
                        <input type="text" name="user_username" id="user_username" class="form-control" placeholder="Nhập tên người dùng" autocomplete="off" required="required">
                    </div>
                    
                    <!-- mật khẩu -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Mật khẩu</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off" required="required">
                    </div>
                    
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Đăng nhập" class="bg-info py-2 px-3 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Bạn chưa có tài khoản? <a href="Dangki.php" class="text-danger">Đăng kí</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
</body>
</html>


<?php

if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    try {
        // Truy vấn kiểm tra người dùng
        $select_sql = "SELECT * FROM khachhang WHERE ten_khach_hang = :user_username";
        $stmt = $conn->prepare($select_sql);
        $stmt->bindParam(':user_username', $user_username, PDO::PARAM_STR);
        $stmt->execute();
        $row_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $row_count = $stmt->rowCount();

        $ip = 1; // IP giả định cho ví dụ

        // Truy vấn kiểm tra giỏ hàng
        $select_sql_cart = "SELECT * FROM giohang WHERE ip_address = :ip";
        $stmt_cart = $conn->prepare($select_sql_cart);
        $stmt_cart->bindParam(':ip', $ip, PDO::PARAM_INT);
        $stmt_cart->execute();
        $row_count_cart = $stmt_cart->rowCount();

        // Xử lý đăng nhập
        if ($row_count > 0) {
            $_SESSION['username'] = $user_username;
            if (password_verify($user_password, $row_data['mat_khau'])) {
                if ($row_count == 1 && $row_count_cart == 0) {
                    $_SESSION['username'] = $user_username;
                    echo "<script>alert('Đăng nhập thành công')</script>";
                    echo "<script>window.open('Profile.php', '_self')</script>";
                } else {
                    $_SESSION['username'] = $user_username;
                    echo "<script>alert('Đăng nhập thành công')</script>";
                    echo "<script>window.open('Thanhtoansp.php', '_self')</script>";
                }
            } else {
                echo "<script>alert('Thông tin đăng nhập không hợp lệ')</script>";
            }
        } else {
            echo "<script>alert('Thông tin đăng nhập không hợp lệ')</script>";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}


?>