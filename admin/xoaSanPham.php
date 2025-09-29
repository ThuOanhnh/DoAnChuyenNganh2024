<?php
include('config/connect.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    try {
        $conn = connectdb(); // Kết nối CSDL từ hàm trong connect.php
        $sql = "DELETE FROM sanpham WHERE ma_san_pham = :product_id"; // Câu lệnh SQL xóa
        $stmt = $conn->prepare($sql);
        $stmt->execute(['product_id' => $product_id]); // Thực thi truy vấn với tham số

        // Chuyển hướng về trang quản lý sản phẩm kèm thông báo
        session_start();
        $_SESSION['message'] = 'Sản phẩm đã được xóa thành công.';
        header('Location: quanlysanpham.php');
        exit;
    } catch (Exception $e) {
        echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
    } finally {
        $conn = null; // Đóng kết nối
    }
} else {
    // Trường hợp không hợp lệ, chuyển hướng về trang quản lý sản phẩm
    header('Location: quanlysanpham.php');
    exit;
}
