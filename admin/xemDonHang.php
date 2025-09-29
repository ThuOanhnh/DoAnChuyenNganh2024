<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

// Kiểm tra mã đơn hàng từ URL
if (!isset($_GET['ma_don_hang']) || empty($_GET['ma_don_hang'])) {
    die('Không tìm thấy mã đơn hàng.');
}

$maDonHang = $_GET['ma_don_hang'];

// Lấy thông tin đơn hàng
$sqlDonHang = "SELECT * FROM donhang WHERE ma_don_hang = ?";
$donHang = selectSQL($sqlDonHang, [$maDonHang]);

if (empty($donHang)) {
    die('Đơn hàng không tồn tại.');
}
$donHang = $donHang[0]; // Lấy dòng đầu tiên vì mã đơn hàng là duy nhất

// Lấy chi tiết đơn hàng
$sqlChiTiet = "SELECT ct.*, sp.ten_san_pham 
               FROM chitietdonhang ct 
               JOIN sanpham sp ON ct.ma_san_pham = sp.ma_san_pham
               WHERE ct.ma_don_hang = ?";
$chiTietDonHang = selectSQL($sqlChiTiet, [$maDonHang]);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Sidebar -->
        <?php include_once('./includes/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Chi tiết đơn hàng: <?= htmlspecialchars($donHang['ma_don_hang']) ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Thông tin đơn hàng -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Thông tin đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($donHang['ma_don_hang']) ?></p>
                            
                            <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($donHang['ngay_dat']) ?></p>
                            <p><strong>Tổng Sản phẩm:</strong> <?= htmlspecialchars($donHang['tong_san_pham']) ?></p>
                            <p><strong>Tổng Tiền:</strong> <?= number_format($donHang['tong_tien'], 0, ',', '.') ?> VND</p>
                            <p><strong>Số hóa đơn:</strong> <?= htmlspecialchars($donHang['so_hoa_don']) ?></p>
                            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($donHang['trang_thai']) ?></p>
                        </div>
                    </div>

                    <!-- Chi tiết sản phẩm -->
                     
                    <div class="card">
                        <div class="card-header">
                            <h3>Chi tiết sản phẩm</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Số hóa đơn</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($chiTietDonHang)) {
                                        echo '<tr><td colspan="5" class="text-center">Không có sản phẩm nào trong đơn hàng.</td></tr>';
                                    } else {
                                        foreach ($chiTietDonHang as $chiTiet) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($chiTiet['ma_don_hang']) . '</td>';
                                            echo '<td>' . htmlspecialchars($chiTiet['ma_san_pham']) . '</td>';
                                            echo '<td>' . htmlspecialchars($chiTiet['so_luong']) . '</td>';
                                            echo '<td>' . (htmlspecialchars($chiTiet['so_hoa_don'])) .'</td>';
                                            echo '<td>' . htmlspecialchars($chiTiet['trang_thai']) . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                             
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="quanlydonhang.php" class="btn btn-primary">Quay lại</a>
                       
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>


 
<!-- Giải thích
 
Kiểm tra ma_don_hang:

Lấy mã đơn hàng từ URL ($_GET['ma_don_hang']).
Nếu không có, hiển thị lỗi và dừng script.
Lấy dữ liệu:

Truy vấn bảng donhang để lấy thông tin tổng quan.
Truy vấn bảng chitietdonhang và kết hợp với bảng sanpham để lấy chi tiết sản phẩm trong đơn hàng.
Hiển thị giao diện:

Thông tin tổng quan của đơn hàng (mã, ngày đặt, tổng tiền, trạng thái).
Bảng chi tiết sản phẩm (mã sản phẩm, tên, số lượng, giá, và thành tiền).
 -->