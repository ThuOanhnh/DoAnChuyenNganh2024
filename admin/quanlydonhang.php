<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

$donhangs = [];
$searchMaDonHang = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Lấy giá trị mã khách hàng từ form
    $searchMaDonHang = $_POST['ma_don_hang'];
    $sql = "SELECT * FROM donhang WHERE ma_don_hang = ?";
    $donhangs = selectSQL($sql, [$searchMaDonHang]); // Gọi hàm lấy dữ liệu với tham số tìm kiếm
} else {
    // Lấy tất cả khách hàng
    $sql = "SELECT * FROM donhang";
    $donhangs = selectSQL($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý thống kê</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    
    <!-- Sidebar -->
    <?php
    include_once('./includes/sidebar.php');
    ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      
      <!-- Header -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Quản lý đơn hàng</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="container-fluid">
  
          <div class="card">
            <div class="card-header">
                <form class="form-inline" method="POST"> <!-- Thêm method="POST" -->
                    <input type="text" name="ma_don_hang" value="<?= htmlspecialchars($searchMaDonHang) ?>" class="form-control mr-2" placeholder="Nhập mã đơn hàng"> <!-- Thêm name="ma_khach_hang" -->
                    <button type="submit" name="search" class="btn btn-primary">Tìm kiếm</button> <!-- Thêm name="search" -->
                </form>
            </div>
          </div>

          <!-- Bảng Thống kê -->
          <div class="card">
            <div class="card-body">
              <table id="statisticsTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mã đơn hàng</th>                    
                    <th>Ngày đặt</th>
                    <th>Tổng Sản Phẩm</th>
                    <th>Tổng Tiền</th>
                    <th>Số hóa đơn</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    if (empty($donhangs)) {
                        echo "<tr><td colspan='7' class='text-center'>Không có đơn hàng nào.</td></tr>";
                    } else {
                        foreach ($donhangs as $donhang) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($donhang['ma_don_hang']) . '</td>';
                            echo '<td>' . htmlspecialchars($donhang['ngay_dat']) . '</td>';
                            echo '<td>' . htmlspecialchars($donhang['tong_san_pham']) . '</td>';
                            echo '<td>' . number_format($donhang['tong_tien'], 0, ',', '.') . ' VND</td>';
                            echo '<td>' . htmlspecialchars($donhang['so_hoa_don']) . '</td>';
                            echo '<td>' . htmlspecialchars($donhang['trang_thai']) . '</td>';
                            echo '<td class="text-center">'; // Thêm lớp text-center vào cột Thao tác
                            echo '<div class="d-flex justify-content-center">'; // Sử dụng d-flex và justify-content-center
                            echo '<a href="xemDonHang.php?ma_don_hang=' . htmlspecialchars($donhang['ma_don_hang']) . '" 
                                  class="btn btn-info btn-sm mx-1">
                                  <i class="fas fa-eye"></i> Xem
                                  </a>';
                            echo '<a href="capNhatDonHang.php?ma_don_hang=' . htmlspecialchars($donhang['ma_don_hang']) . '" 
                                  class="btn btn-warning btn-sm mx-1">
                                  <i class="fas fa-edit"></i> Cập nhật
                                  </a>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                </tbody>
              </table>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>
