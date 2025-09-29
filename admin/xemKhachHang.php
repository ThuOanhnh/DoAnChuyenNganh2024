<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

// Kiểm tra xem `ma_khach_hang` có được truyền qua URL không
if (!isset($_GET['ma_khach_hang']) || empty($_GET['ma_khach_hang'])) {
    echo "<script>alert('Không tìm thấy mã khách hàng.'); window.location.href='quanlykhachhang.php';</script>";
    exit;
}

// Lấy mã khách hàng từ URL
$maKhachHang = $_GET['ma_khach_hang'];

// Truy vấn thông tin khách hàng từ cơ sở dữ liệu
$sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
$khachhang = selectSQL($sql, [$maKhachHang]);

if (empty($khachhang)) {
    echo "<script>alert('Khách hàng không tồn tại.'); window.location.href='quanlykhachhang.php';</script>";
    exit;
}

// Dữ liệu khách hàng
$khachhang = $khachhang[0];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Khách Hàng</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết khách hàng</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Card hiển thị thông tin chi tiết -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin khách hàng</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Mã khách hàng:</th>
                                <td><?= htmlspecialchars($khachhang['ma_khach_hang']) ?></td>
                            </tr>
                            <tr>
                                <th>Tên khách hàng:</th>
                                <td><?= htmlspecialchars($khachhang['ten_khach_hang']) ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= htmlspecialchars($khachhang['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Mật khẩu:</th>
                                <td><?= htmlspecialchars($khachhang['mat_khau']) ?></td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td><?= htmlspecialchars($khachhang['so_dien_thoai']) ?></td>
                            </tr>
                            <tr>
                                <th>Địa chỉ:</th>
                                <td><?= htmlspecialchars($khachhang['dia_chi']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="quanlykhachhang.php" class="btn btn-primary">Quay lại</a>
                       
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Các thư viện JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
