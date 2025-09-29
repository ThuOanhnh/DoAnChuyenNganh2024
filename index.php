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
        body{
            overflow-x: hidden;
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

        <!-- gọi giỏ hàng -->
        <?php
        Giohang();

        ?>
        <!-- 3  main-->
        <div class="top">

        </div>

        <!-- 4  main-->

        <div class="row ">
            <div class="col-md-3 bg-secondary p-0 ">
                <!-- slibar -->
                <!-- thương hiệu -->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="" class="nav-link text-light">
                            <h4>THƯƠNG HIỆU</h4>
                        </a>
                    </li>
                    <?php
                    getThuongHieu();
                    ?>

                </ul>
                <!-- danh mục -->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="" class="nav-link text-light">
                            <h4>DANH MỤC</h4>
                        </a>
                    </li>
                    <?php
                    getDanhMuc();
                    ?>

                </ul>
            </div>
            <div class="col-md-9">
                <!-- sản phẩm  -->
                <div class="row">
                    <!-- thêm sản phẩm bằng php -->
                    <?php
                    getSanPham();
                    getUniqueDanhMuc();
                    getUniqueThuongHieu();
                    $ip = getIPAddress();  
                    //echo 'User Real IP Address - '.$ip; 
                    ?>
                </div>
                <!-- end san pham -->
            </div>


        </div>
        <!-- footer -->
        <?php include './page/footer.php'  ?>
    </div>





    <!-- js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>