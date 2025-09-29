<?php
include './function/comon_function.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="font/themify-icons/themify-icons.css">
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font icon -->
    <link rel="stylesheet" href="./font/fontawesome-free-6.7.0/css/all.min.css">

    <link rel="stylesheet" href="./css/style.css">
    <title>LAPTOP79</title>
    <style>
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!-- header -->
    <!-- 1 -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid">
                <img src="./image/logo2.jpg" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="GioiThieu.php">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="LienHe.php">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="GioHang.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php Cart_item(); ?></sup></a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- 2 -->
        <nav class="navbar navbar-expand-lg  navbar-dart bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php



                if (isset($_SESSION['username'])) {
                    echo "
<li class='nav-item'>
<a class='nav-link' href='#'>Chào " . htmlspecialchars($_SESSION['username']) . "!</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='./user/Dangxuat.php'><i class='fa-solid fa-right-to-bracket'></i> Đăng xuất</a>
</li>
";
                } else {
                    echo "
<li class='nav-item'>
<a class='nav-link' href='#'>Chào bạn!</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='./user/Dangnhap.php'><i class='fa-solid fa-right-to-bracket'></i> Đăng nhập</a>
</li>
";
                }
                ?>
            </ul>
        </nav>

        <!-- gọi giỏ hàng -->
        <?php
        Giohang();
        ?>
        <!-- 3  main-->
        <div class="top">

        </div>

        <!-- table giỏ hàng-->

        <div class="container">
            <h1 class="text-center ">Giỏ hàng của bạn</h1>
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center p-3">

                        <tbody>
                            <!-- code php đỗ dữ liệu -->
                            <?php
                            global $conn;
                            $ip = 1;
                            $tong = 0;

                            // Sử dụng PDO để lấy dữ liệu từ bảng 'giohang'
                            $cart_sql = "SELECT * FROM giohang WHERE ip_address = :ip";
                            $stmt = $conn->prepare($cart_sql);
                            $stmt->bindParam(':ip', $ip, PDO::PARAM_INT);
                            $stmt->execute();
                            $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $kq_count = count($kq);

                            if ($kq_count > 0) {
                                echo "<thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Số lượng</th>
            <th>Tổng giá</th>
            <th>Xóa</th>
            <th colspan='2'>Thao tác</th>
        </tr>
    </thead>
    <tbody>";

                                foreach ($kq as $row) {
                                    $masp = $row['ma_san_pham'];
                                    //thêm
                                    $so_luong = $row['so_luong'];

                                    // Sử dụng PDO để lấy dữ liệu từ bảng 'sanpham'
                                    $select_sp = "SELECT * FROM sanpham WHERE ma_san_pham = :masp";
                                    $stmt_sp = $conn->prepare($select_sp);
                                    $stmt_sp->bindParam(':masp', $masp, PDO::PARAM_INT);
                                    $stmt_sp->execute();
                                    $kq_sp = $stmt_sp->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($kq_sp as $row_sp) {
                                        $sp_price = $row_sp['gia'];
                                        $sp_tile = $row_sp['ten_san_pham'];
                                        $sp_img = $row_sp['anh_url'];
                                        //$tong += $sp_price;
                                        $tong += $sp_price * $so_luong;
                                        echo "
        <tr>
            <td>{$sp_tile}</td>
            <td><img src='./image/{$sp_img}' alt='' class='cart-img'></td>
           <td>
                <input type='text' class='form-input w-50' name='qty[{$masp}]' value='{$so_luong}'>
            </td>

            <td>" . number_format($sp_price * $so_luong, 0, ',', '.') . " VND</td>
            <td><input type='checkbox' name='removeitem[]' value='{$masp}'></td>
            <td>
                <input type='submit' value='Cập nhật' class='bg-secondary p-3 py-2 mx-3 border-0 text-light' name='update_cart'>
                <input type='submit' value='Xóa' class='bg-secondary p-3 py-2 mx-3 border-0 text-light' name='remove_cart'>
            </td>
        </tr>";

                            ?>
                            <!-- update cart -->
                                        <?php
                                        if (isset($_POST['update_cart'])) {
                                            foreach ($_POST['qty'] as $masp => $quantity) {
                                                // Kiểm tra số lượng hợp lệ
                                                if (is_numeric($quantity) && $quantity > 0) {
                                                    $quantity = (int)$quantity;
                                                } else {
                                                    $quantity = 1; // Số lượng mặc định nếu không hợp lệ
                                                }

                                                // Cập nhật số lượng trong giỏ hàng
                                                $update_cart = "UPDATE giohang SET so_luong = :quantity WHERE ma_san_pham = :masp AND ip_address = :ip_address";
                                                $stmt_update = $conn->prepare($update_cart);
                                                $stmt_update->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                                                $stmt_update->bindParam(':masp', $masp, PDO::PARAM_INT);
                                                $stmt_update->bindParam(':ip_address', $ip, PDO::PARAM_STR);
                                                $stmt_update->execute();
                                            }

                                            // Reload trang để cập nhật thông tin giỏ hàng
                                            echo "<script>window.open('GioHang.php', '_self');</script>";
                                        }
                                        ?>

                            <?php
                                    }
                                }
                            } else {
                                echo "<h2 class='text-center text-danger'>Không có sản phẩm nào trong giỏ hàng! Hãy quay về trang chủ để tiếp tục mua sắm</h2>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Phần tổng tiền và thanh toán -->
                    <div class="d-flex mb-5">
                        <?php
                        if ($kq_count > 0) {
                            echo "
                            <h4 class='px-3'>Tổng tiền: <strong class='text-info'>" . number_format($tong, 0, ',', '.') . " VND</strong></h4>
                            <button class='bg-secondary p-3 py-2 mx-3 border-0 text-light'>
                                <a href='./user/Thanhtoan.php' class='text-light text-decoration-none'>Thanh toán</a>
                            </button>";
                        }
                        ?>

                    </div>
            </div>
        </div>
        </form>

        <!--  hàm xóa sản phẩm trong giỏ hàng-->

        <?php
        

        function remove_cart_item()
        {
            global $conn; // Kết nối PDO đã được thiết lập
            if (isset($_POST['remove_cart'])) {
                foreach ($_POST['removeitem'] as $remove_id) {
                    echo $remove_id;

                    // Chuẩn bị câu truy vấn xóa với PDO
                    $delete_query = "DELETE FROM giohang WHERE ma_san_pham = :remove_id";
                    $stmt = $conn->prepare($delete_query);

                    // Bind giá trị cho tham số :remove_id
                    $stmt->bindParam(':remove_id', $remove_id, PDO::PARAM_STR);

                    // Thực thi câu truy vấn
                    if ($stmt->execute()) {
                        echo "<script>window.open('GioHang.php', '_self')</script>";
                    }
                }
            }
        }
        echo $remove_item = remove_cart_item();




        ?>

    </div>





    <!-- js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>