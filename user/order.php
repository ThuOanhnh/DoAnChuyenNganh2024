<?php

include '../connect.php';
$conn = connectdb();
//include '.././function/comon_function.php';


if (isset($_GET['ma_Khach_hang'])) {
    $id = $_GET['ma_Khach_hang'];
}

//lấy tổng sản phẩm và tổng giá của các sản phẩm



// Khởi tạo các giá trị cần thiết
$get_ip = 1; // Giả định địa chỉ IP của người dùng
$tong = 0; // Tổng tiền
$count_pro = 0; // Tổng số sản phẩm
$sohoadon = mt_rand(); // Số hóa đơn ngẫu nhiên
$trangthai = 'Đang xử lý'; // Trạng thái mặc định

// Truy vấn lấy thông tin sản phẩm từ giỏ hàng dựa trên IP
$cart_sql_gia = "SELECT * FROM giohang WHERE ip_address = :ip_address";
$stmt = $conn->prepare($cart_sql_gia);
$stmt->bindParam(':ip_address', $get_ip, PDO::PARAM_INT);
$stmt->execute();

// Duyệt qua từng sản phẩm trong giỏ hàng
while ($row_gia = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $masp = $row_gia['ma_san_pham']; // Mã sản phẩm từ bảng "giohang"
    $pro_soluong = $row_gia['so_luong']; // Số lượng từ bảng "giohang"

    // Truy vấn lấy giá sản phẩm từ bảng "sanpham"
    $select_pro = "SELECT gia FROM sanpham WHERE ma_san_pham = :ma_san_pham";
    $stmt_pro = $conn->prepare($select_pro);
    $stmt_pro->bindParam(':ma_san_pham', $masp, PDO::PARAM_STR);
    $stmt_pro->execute();

    // Lấy giá của sản phẩm và tính tổng
    if ($row_pro_price = $stmt_pro->fetch(PDO::FETCH_ASSOC)) {
        $pro_price = $row_pro_price['gia']; // Giá sản phẩm từ bảng "sanpham"
        $tong += $pro_price * $pro_soluong; // Tổng tiền = giá * số lượng
        $count_pro += $pro_soluong; // Tổng số lượng sản phẩm
    }
    // Chèn dữ liệu vào chitietdonhang
    $insert_chitiet = "INSERT INTO chitietdonhang ( ma_san_pham, so_luong, so_hoa_don, trang_thai)
                        VALUES ( :ma_san_pham, :so_luong, :so_hoa_don, :trang_thai)";
    $stmt_chitiet = $conn->prepare($insert_chitiet);
   
    $stmt_chitiet->bindParam(':ma_san_pham', $masp, PDO::PARAM_INT);
    $stmt_chitiet->bindParam(':so_luong', $pro_soluong, PDO::PARAM_INT); // Sử dụng $pro_soluong
    $stmt_chitiet->bindParam(':so_hoa_don', $sohoadon, PDO::PARAM_STR);
    $stmt_chitiet->bindParam(':trang_thai', $trangthai, PDO::PARAM_STR);
    $stmt_chitiet->execute();
}
// Xử lý trường hợp không có sản phẩm trong giỏ hàng
if ($count_pro == 0) {
    die("Giỏ hàng trống, không thể tạo hóa đơn!");
}

// Chèn dữ liệu vào bảng donhang
$insert_hoadon = "INSERT INTO donhang (ma_khach_hang, ngay_dat, tong_san_pham, tong_tien, so_hoa_don, trang_thai)
                  VALUES (:ma_khach_hang, NOW(), :tong_san_pham, :tong_tien, :so_hoa_don, :trang_thai)";
$stmt_hoadon = $conn->prepare($insert_hoadon);

// Gán giá trị cho các tham số
$stmt_hoadon->bindParam(':ma_khach_hang', $id, PDO::PARAM_INT);
$stmt_hoadon->bindParam(':tong_san_pham', $count_pro, PDO::PARAM_INT);
$stmt_hoadon->bindParam(':tong_tien', $tong, PDO::PARAM_STR);
$stmt_hoadon->bindParam(':so_hoa_don', $sohoadon, PDO::PARAM_STR);
$stmt_hoadon->bindParam(':trang_thai', $trangthai, PDO::PARAM_STR);

// Thực thi câu lệnh và kiểm tra kết quả
if ($stmt_hoadon->execute()) {
    echo "<script>alert('Đơn hàng được đặt thành công!')</script>";
    echo "<script>window.open('Profile.php', '_self')</script>";
} else {
    echo "<script>alert('Đã xảy ra lỗi, vui lòng thử lại!')</script>";
}


// trạng thái xử lý đơn hàng sau khi thanh toán đơn hàng 





// xóa sản phẩm trong giỏ hàng sau khi thanh toán
$empty_cart = "DELETE FROM giohang WHERE ip_address = :ip_address";

$stmt = $conn->prepare($empty_cart);
$stmt->bindParam(':ip_address', $get_ip);
$stmt->execute();
