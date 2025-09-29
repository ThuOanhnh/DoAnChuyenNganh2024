
<?php
// include('dao/sanphamDAO.php');
include('dao/xoaSanPhamDao.php');
xoaSanPham($conn, $product_id);


function xoaSanPham($conn, $product_id) {
    $sql = "DELETE FROM sanpham WHERE ma_san_pham = :product_id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['product_id' => $product_id]);
}
?>
