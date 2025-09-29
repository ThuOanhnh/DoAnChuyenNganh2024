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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tổng giá: <?php TongTien(); ?> VND</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="TimKiem.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Bạn đang tìm gì?" aria-label="Search" name="search_data">
                        <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                        <input type="submit" value="Tìm" class="btn btn-outline-light" name="search_sanpham">
                    </form>
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

        <?php
        $ip = getIPAddress();
        ?>

        <!-- 4  main-->
        <header class="bg-info">
            <h1>Liên Hệ Với Chúng Tôi</h1>
            <p>Hãy để lại thông tin, chúng tôi sẽ liên lạc với bạn sớm nhất</p>
        </header>

        <div class="container">
            <!-- Phần thông tin liên hệ -->
            <div class="contact-info ">
                <h2>Thông Tin Liên Hệ</h2>
                <p><strong>Địa chỉ:</strong> 180 Cao Lỗ, Phường 4, Quận 8, Thành Phố Hồ Chí Minh</p>
                <p><strong>Số điện thoại:</strong> 0961568433</p>
                <p><strong>Email:</strong> lienhe@laptop79.com</p>
                <p><strong>Thời gian làm việc:</strong> Thứ 2 - Thứ 7, 8:00 - 18:00</p>
            </div>

            <!-- Phần biểu mẫu liên hệ -->
            <div class="contact-form">
                <h2>Gửi Thông Tin Liên Hệ</h2>
                <form action="" method="POST">
                    <label for="name">Họ và Tên</label>
                    <input type="text" id="name" name="name" placeholder="Nhập họ và tên của bạn" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>

                    <label for="phone">Số Điện Thoại</label>
                    <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" required>

                    <label for="message">Nội Dung Liên Hệ</label>
                    <textarea id="message" name="message" rows="5" placeholder="Nhập nội dung liên hệ" required></textarea>

                    <button type="submit" class="btn btn-outline-light bg-info">Gửi Liên Hệ</button>
                </form>
            </div>
        </div>





    </div>
    <!-- footer -->
    <?php include './page/footer.php'  ?>
    </div>





    <!-- js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>