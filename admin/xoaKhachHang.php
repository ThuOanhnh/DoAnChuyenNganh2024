<?php
include('config/connect.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    try {
        $conn = connectdb(); // Kết nối CSDL từ hàm trong connect.php
        $sql = "DELETE FROM khachhang WHERE ma_khach_hang = :product_id"; // Câu lệnh SQL xóa
        $stmt = $conn->prepare($sql);
        $stmt->execute(['product_id' => $product_id]); // Thực thi truy vấn với tham số

        // Chuyển hướng về trang quản lý sản phẩm kèm thông báo
        session_start();
        $_SESSION['message'] = 'Khách hàng đã được xóa thành công.';
        header('Location: quanlykhachhang.php');
        exit;
    } catch (Exception $e) {
        echo "Lỗi khi xóa khách hàng: " . $e->getMessage();
    } finally {
        $conn = null; // Đóng kết nối
    }
} else {
    // Trường hợp không hợp lệ, chuyển hướng về trang quản lý sản phẩm
    header('Location: quanlykhachhang.php');
    exit;
}
