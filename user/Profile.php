<?php
include '../connect.php';
$conn = connectdb();

session_start();

// số lượng sản phẩm trong giỏ hàng
function Cart_item()
{
    if (isset($_GET['them_gio_hang'])) {
        global $conn;
        $ip = getIPAddress();
        try {
            // Chuẩn bị câu lệnh PDO
            $stmt = $conn->prepare("SELECT * FROM giohang WHERE ip_address = :ip");
            // Gán giá trị tham số
            $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
            // Thực thi truy vấn
            $stmt->execute();
            // Lấy số dòng trả về
            $count = $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        global $conn;
        $ip = 1;
        try {
            // Chuẩn bị câu lệnh PDO
            $stmt = $conn->prepare("SELECT * FROM giohang WHERE ip_address = :ip");
            // Gán giá trị tham số
            $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
            // Thực thi truy vấn
            $stmt->execute();
            // Lấy số dòng trả về
            $count = $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    echo $count;
}

// tổng tiền các sản phẩm trong giỏ hàng


function TongTien()
{
    global $conn;
    $tong = 0; 
    $ip = 1; 

    // Truy vấn giỏ hàng với thông tin mã sản phẩm và số lượng
    $cart_sql = "SELECT ma_san_pham, so_luong FROM giohang WHERE ip_address = :ip";
    $stmt = $conn->prepare($cart_sql);
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    // Duyệt qua từng sản phẩm trong giỏ hàng
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $masp = $row['ma_san_pham'];
        $so_luong = $row['so_luong']; // Số lượng sản phẩm

        // Truy vấn giá sản phẩm từ bảng `sanpham`
        $select_pro = "SELECT gia FROM sanpham WHERE ma_san_pham = :masp";
        $stmt_pro = $conn->prepare($select_pro);
        $stmt_pro->bindParam(':masp', $masp);
        $stmt_pro->execute();

        $row_pro = $stmt_pro->fetch(PDO::FETCH_ASSOC);

        // Tính tiền (giá * số lượng) và cộng vào tổng
        $tong += $row_pro['gia'] * $so_luong;
    }

    // Hiển thị tổng tiền đã định dạng
    echo number_format($tong, 0, ',', '.');
}

// thêm giỏ hàng 


function Giohang()
{
    if (isset($_GET['them_gio_hang'])) {
        global $conn; // $conn là đối tượng PDO đã được kết nối trước đó
        $masp = $_GET['them_gio_hang'];

        $ip = 1;

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $sql = "SELECT * FROM giohang WHERE ma_san_pham = :masp AND ip_address = :ip";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':masp' => $masp, ':ip' => $ip]);
        $num = $stmt->rowCount();

        if ($num > 0) {
            echo "<script>alert('Sản phẩm đã có trong giỏ hàng!')</script>";
            echo "<script>window.open('index.php', '_self')</script>";
        } else {
            // Thêm sản phẩm vào giỏ hàng
            $insert_sql = "INSERT INTO giohang (ma_san_pham, so_luong, ip_address) VALUES (:masp, 1, :ip)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->execute([':masp' => $masp, ':ip' => $ip]);


            echo "<script>alert('Đã thêm vào giỏ hàng!')</script>";
            echo "<script>window.open('index.php', '_self')</script>";
        }
    }
}

// hàm tìm kiếm sản phẩm 
function TimKiemSanPham()
{
    global $conn; // $conn là đối tượng PDO đã kết nối trước đó

    if (isset($_GET['search_sanpham'])) {
        $search_value = $_GET['search_data'];

        try {
            // Chuẩn bị truy vấn tìm kiếm với PDO
            $timkiem_sql = "SELECT * FROM sanpham WHERE tu_khoa LIKE :search_value";
            $stmt = $conn->prepare($timkiem_sql);

            // Gắn giá trị vào tham số và thực thi truy vấn
            $stmt->execute(['search_value' => '%' . $search_value . '%']);



            $num_row = $stmt->rowCount(); // Đếm số hàng trả về
            if ($num_row == 0) {
                echo "<h2 class='text-center text-danger'>Không có sản phẩm bạn đang tìm!</h2>";
            }
            // Lấy kết quả và hiển thị
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ma = $row['ma_san_pham'];
                $ten = $row['ten_san_pham'];
                $mota = $row['mo_ta'];
                $gia = $row['gia'];
                $anh = $row['anh_url'];
                $math = $row['ma_thuong_hieu'];
                $madm = $row['ma_danh_muc'];

                echo '
<div class="col-md-4 mb-2">
    <div class="card">
        <img src="./image/' . htmlspecialchars($anh) . '" class="card-img-top" alt="' . htmlspecialchars($ten) . '">
        <div class="card-body">
            <h5 class="card-title">' . htmlspecialchars($ten) . '</h5>
            <p class="card-text">Giá: ' . htmlspecialchars(number_format($gia, 0, ',', '.')) . ' VND </p>
            <p class="card-text">' . htmlspecialchars($mota) . '</p>
            <a href="index.php?them_gio_hang=' . htmlspecialchars($ma) . '" class="btn btn-info">Thêm giỏ hàng</a>
            <a href="ChiTietSanPham.php?ma_san_pham=' . htmlspecialchars($ma) . '"class="btn btn-secondary">Chi tiết</a>
        </div>
    </div>
</div>';
            }
        } catch (PDOException $e) {

            echo "Lỗi: " . $e->getMessage();
        }
    }
}

// lấy khách hàng trong chitietdonhang

function get_KhachHang()
{
    global $conn; // PDO connection
    $username = $_SESSION['username'];

    // Prepare and execute the query to fetch customer details
    $get_detail = "SELECT * FROM khachhang WHERE ten_khach_hang = :username";
    $stmt = $conn->prepare($get_detail);
    $stmt->execute([':username' => $username]);

    while ($row_sql = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userid = $row_sql['ma_khach_hang'];

        if (!isset($_GET['Suataikhoan']) && !isset($_GET['Donhangdadat']) && !isset($_GET['Xoataikhoan'])) {
            // Prepare and execute the query to fetch orders
            $get_order = "SELECT * FROM donhang WHERE ma_khach_hang IS NULL AND trang_thai = 'Đang xử lý'";
            $stmt_order = $conn->prepare($get_order);
            $stmt_order->execute();

            $rowCount = $stmt_order->rowCount();

            if ($rowCount > 0) {
                echo "<h3 class='text-center my-5 mb-2'>Bạn có <span class='text-danger'>$rowCount</span> đơn hàng đang xử lý</h3>
                <p class='text-center' ><a href='Profile.php?Donhangdadat'>Chi tiết đơn hàng</a></p>";
            }else{
                echo "<h3 class='text-center my-5 mb-2'>Bạn không có đơn hàng nào đang xử lý</h3>
                <p class='text-center' ><a href='../index.php'>Tiếp tục mua sắm</a></p>";
            }
        }
    }
}

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
    <link rel="stylesheet" href=".././font/fontawesome-free-6.7.0/css/all.min.css">

    <link rel="stylesheet" href=".././css/style.css">
    <title>LAPTOP79</title>
    <style>
        body {
            overflow-x: hidden;
        }

        .profile_img {
            width: 90%;
            /* height: 50%; */
            /* height: 100%; */

            margin: auto;
            display: block;
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
                <img src=".././image/logo2.jpg" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../GioiThieu.php">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../LienHe.php">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Profile.php">Tài khoản của tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../GioHang.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php Cart_item(); ?></sup></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tổng giá: <?php TongTien(); ?> VND</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="../TimKiem.php" method="get">
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
        <a class='nav-link' href='Dangxuat.php'><i class='fa-solid fa-right-to-bracket'></i> Đăng xuất</a>
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

        <!-- phần thông tin khách hàng -->
        <div class="row">
            <div class="col-md-3 ">
                <ul class="navbar-nav bg-secondary text-center" style="height:100vh">
                    <li class="nav-item bg-info">
                        <a class="nav-link text-alight" href="#">
                            <h4>Thông tin cá nhân</h4>
                        </a>
                    </li>

                    <?php
                    
                    $username = $_SESSION['username'];
                    $query = "SELECT * FROM khachhang WHERE ten_khach_hang = :username";

                    $stmt = $conn->prepare($query); 
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
                    $stmt->execute(); 

                    $row_img = $stmt->fetch(PDO::FETCH_ASSOC); 

                    if ($row_img) {
                        $user_img = $row_img['anh_url']; 
                        echo "<li class='nav-item'>
                                <img src='./user_image/$user_img' class='profile_img my-4' alt=''>
                            </li>";
                    } else {
                        echo "<li class='nav-item'>Không tìm thấy ảnh người dùng.</li>";
                    }


                    ?>

                    <li class="nav-item ">
                        <a class="nav-link text-alight" href="Profile.php?Suataikhoan">Sửa thông tin</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-alight" href="Profile.php">Xác nhận thanh toán</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-alight" href="Profile.php?Donhangdadat">Đơn hàng đã đặt</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-alight" href="Profile.php?Xoataikhoan">Xóa tài khoản</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-alight" href="Dangxuat.php">Đăng xuất</a>
                    </li>
                </ul>

            </div>
            <div class="col-md-9">
            <?php 
            get_KhachHang();
            if(isset($_GET['Donhangdadat'])){
                include ('Donhangdadat.php');
            }

            ?>
            </div>
        </div>


        <!-- footer -->
        <?php include '.././page/footer.php'  ?>
    </div>





    <!-- js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>