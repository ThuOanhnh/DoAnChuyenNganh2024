
<?php
include('dao/xoaKhachHangDao.php');
xoaSanPham($conn, $product_id);


function xoaSanPham($conn, $product_id) {
    $sql = "DELETE FROM khachhang WHERE ma_khach_hang = :product_id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['product_id' => $product_id]);
}
?>
