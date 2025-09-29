<?php
include '../connect.php';
$conn = connectdb();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container-fluid my-3">
        <h2 class="text-center ">
            ĐĂNG KÍ
        </h2>
        <div class="row d-flex aligh-item-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- username -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Tên người dùng</label>
                        <input type="text" name="user_username" id="user_username" class="form-control" placeholder="Nhập tên người dùng" autocomplete="off" required="required">
                    </div>
                    <!-- email -->
                    <div class="form-outline mb-4">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Nhập email" autocomplete="off" required="required">
                    </div>
                    <!-- hình ảnh user -->
                    <div class="form-outline mb-4">
                        <label for="user_image" class="form-label">Hình ảnh</label>
                        <input type="file" name="user_image" id="user_image" class="form-control" required="required">
                    </div>
                    <!-- mật khẩu -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Mật khẩu</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off" required="required">
                    </div>
                    <!-- xác nhận mật khẩu -->
                    <div class="form-outline mb-4">
                        <label for="conf_user_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="conf_user_password" id="conf_user_password" class="form-control" placeholder="Nhập lại mật khẩu" autocomplete="off" required="required">
                    </div>
                    <!-- Địa chỉ -->
                    <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">Địa chỉ</label>
                        <input type="text" name="user_address" id="user_address" class="form-control" placeholder="Nhập địa chỉ" autocomplete="off" required="required">
                    </div>
                    <!-- số điện thoại-->
                    <div class="form-outline mb-4">
                        <label for="user_contact" class="form-label">Số điện thoại</label>
                        <input type="text" name="user_contact" id="user_contact" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off" required="required">
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Đăng kí" class="bg-info py-2 px-3 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Bạn đã có tài khoản? <a href="Dangnhap.php" class="text-danger">Đăng nhập</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>

<!-- code php -->

<?php


global $conn;

if (isset($_POST['user_register'])) {
    // Lấy dữ liệu từ form
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_pasword = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];

    $user_ip = 1; // Giả định địa chỉ IP

    // Kiểm tra xem tên người dùng hoặc email đã tồn tại chưa
    $select_query = "SELECT * FROM khachhang WHERE ten_khach_hang = :user_username OR email = :user_email";
    $stmt_select = $conn->prepare($select_query);
    $stmt_select->bindParam(':user_username', $user_username);
    $stmt_select->bindParam(':user_email', $user_email);
    $stmt_select->execute();
    $row_count = $stmt_select->rowCount();

    if ($row_count > 0) {
        echo "<script>alert('Tên người dùng hoặc email đã tồn tại!');</script>";
    } else if ($user_password !== $conf_user_password) {
        echo "<script>alert('Mật khẩu không khớp!');</script>";
    } else {
        // Di chuyển ảnh vào thư mục
        if (!empty($user_image)) {
            move_uploaded_file($user_image_tmp, "./user_image/$user_image");
        }

        // Thêm người dùng mới vào cơ sở dữ liệu
        $insert_query = "INSERT INTO khachhang (ten_khach_hang, email, mat_khau, so_dien_thoai, dia_chi, ip, anh_url) 
                         VALUES (:user_username, :user_email, :hash_pasword, :user_contact, :user_address, :user_ip, :user_image)";
        try {
            $stmt_insert = $conn->prepare($insert_query);
            $stmt_insert->bindParam(':user_username', $user_username);
            $stmt_insert->bindParam(':user_email', $user_email);
            $stmt_insert->bindParam(':hash_pasword', $hash_pasword);
            $stmt_insert->bindParam(':user_contact', $user_contact);
            $stmt_insert->bindParam(':user_address', $user_address);
            $stmt_insert->bindParam(':user_ip', $user_ip);
            $stmt_insert->bindParam(':user_image', $user_image);
            $stmt_insert->execute();

            echo "<script>alert('Đăng ký thành công!');</script>";
        } catch (PDOException $e) {
            echo "Lỗi khi đăng ký: " . $e->getMessage();
        }
    }

    //chọn sản phẩm trong gior hàng 
    
    $sql_item_cart = "SELECT * FROM giohang WHERE ip_address = :user_ip";

    try {
        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($sql_item_cart);
        // Gắn giá trị cho tham số `:user_ip`
        $stmt->bindParam(':user_ip', $user_ip, PDO::PARAM_STR);
        // Thực thi truy vấn
        $stmt->execute();
        // Lấy số dòng trả về
        $row_count = $stmt->rowCount();

        if ($row_count > 0) {
            // Nếu giỏ hàng có sản phẩm
            $_SESSION['username'] = $user_username;
            echo "<script>alert('Bạn đã có sản phẩm trong giỏ hàng.')</script>";
            echo "<script>window.open('Thanhtoan.php', '_self')</script>";
        } else {
            // Nếu giỏ hàng trống
            echo "<script>window.open('../index.php', '_self')</script>";
        }
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        echo "Lỗi khi truy vấn dữ liệu: " . $e->getMessage();
    }
}


?>