<?php

include './connect.php';
$conn = connectdb();


function getSanPham()
{
    global $conn;

    // kiểm tra điều kiện 
    if (!isset($_GET['danhmuc'])) {
        if (!isset($_GET['thuonghieu'])) {



            $select_query = "SELECT * FROM sanpham order by rand() limit 0, 6";
            $stmt = $conn->prepare($select_query);
            $stmt->execute();

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
    <a href="index.php?them_gio_hang=' . htmlspecialchars($ma) . '" name="themgiohang" class="btn btn-info">Thêm giỏ hàng</a>
    <a href="ChiTietSanPham.php?ma_san_pham=' . htmlspecialchars($ma) . '"class="btn btn-secondary">Chi tiết</a>
</div>
</div>
</div>';
            }
        }
    }
}


// chi tiết sản phẩm






// lấy thương hiệu duy nhất
function getUniqueThuongHieu()
{
    global $conn;

    // kiểm tra điều kiện 

    if (isset($_GET['thuonghieu'])) {
        $math = $_GET['thuonghieu'];

        // Câu truy vấn với PDO
        $select_query = "SELECT * FROM sanpham WHERE ma_thuong_hieu = :math";
        $stmt = $conn->prepare($select_query); // Chuẩn bị truy vấn
        $stmt->bindParam(':math', $math, PDO::PARAM_INT); // Gắn giá trị cho tham số
        $stmt->execute(); // Thực thi truy vấn

        $num_row = $stmt->rowCount(); // Đếm số hàng trả về
        if ($num_row == 0) {
            echo "<h2 class='text-center text-danger'>Không có sản phẩm trong thương hiệu bạn chọn</h2>";
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
    }
}


// lấy danh mục duy nhất 

function getUniqueDanhMuc()
{
    global $conn;

    // kiểm tra điều kiện 

    if (isset($_GET['danhmuc'])) {
        $madm = $_GET['danhmuc'];

        // Câu truy vấn với PDO
        $select_query = "SELECT * FROM sanpham WHERE ma_danh_muc = :madm";
        $stmt = $conn->prepare($select_query); // Chuẩn bị truy vấn
        $stmt->bindParam(':madm', $madm, PDO::PARAM_INT); // Gắn giá trị cho tham số
        $stmt->execute(); // Thực thi truy vấn

        $num_row = $stmt->rowCount(); // Đếm số hàng trả về
        if ($num_row == 0) {
            echo "<h2 class='text-center text-danger'>Không có sản phẩm trong danh mục bạn chọn</h2>";
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
    }
}


function getThuongHieu()
{
    global $conn;
    $select_ten = "SELECT * FROM thuonghieu";
    $stmt = $conn->prepare($select_ten); // Chuẩn bị câu truy vấn
    $stmt->execute(); // Thực thi câu truy vấn

    // Lặp qua các kết quả
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ten = $row['ten_thuong_hieu'];
        $ma = $row['ma_thuong_hieu'];
        echo "
        <li><a href='index.php?thuonghieu=$ma' class='nav-link text-light'>$ten</a></li>
    ";
    }
}


function getDanhMuc()
{
    global $conn;
    $select_ten = "SELECT * FROM danhmuc";
    $stmt = $conn->prepare($select_ten); // Chuẩn bị câu truy vấn
    $stmt->execute(); // Thực thi câu truy vấn

    // Lặp qua các kết quả
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ten = $row['ten_danh_muc'];
        $ma = $row['ma_danh_muc'];
        echo "
        <li><a href='index.php?danhmuc=$ma' class='nav-link text-light'>$ten</a></li>
    ";
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
// lấy ip số lượng sản phẩm
function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address  
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  

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
    $tong = 0; // Biến lưu tổng tiền
    $ip = 1; // Địa chỉ IP giả định

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
?>