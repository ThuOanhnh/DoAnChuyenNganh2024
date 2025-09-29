<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

$khachhangs = [];
$searchTenKhachHang = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Lấy giá trị mã khách hàng từ form
    $searchTenKhachHang = $_POST['ten_khach_hang'];
    $sql = "SELECT * FROM khachhang WHERE ten_khach_hang LIKE ?";
    $khachhangs = selectSQL($sql, ["%$searchTenKhachHang%"]); // Sửa để tìm kiếm với LIKE
} else {
    // Lấy tất cả khách hàng
    $sql = "SELECT * FROM khachhang";
    $khachhangs = selectSQL($sql);
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý khách hàng</title>
  <!-- Link tới Admin CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include_once('../admin/includes/sidebar.php'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Header -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Quản lý khách hàng</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card-header">
            <form class="form-inline" method="POST">
              <input 
                type="text" 
                name="ten_khach_hang" 
                value="<?= htmlspecialchars($searchTenKhachHang) ?>" 
                class="form-control mr-2" 
                placeholder="Nhập tên khách hàng"> 
              <button type="submit" name="search" class="btn btn-primary">Tìm kiếm</button>
            </form>
          </div>

          <!-- Bảng danh sách khách hàng -->
          <div class="card">
            <div class="card-body">
              <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Mật khẩu</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (empty($khachhangs)) {
                    echo "<tr><td colspan='7' class='text-center'>Không có khách hàng nào.</td></tr>";
                  } else {
                    foreach ($khachhangs as $khachhang) {
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($khachhang['ma_khach_hang']) . '</td>';
                      echo '<td>' . htmlspecialchars($khachhang['ten_khach_hang']) . '</td>';
                      echo '<td>' . htmlspecialchars($khachhang['email']) . '</td>';
                      echo '<td>' . htmlspecialchars($khachhang['mat_khau']) . '</td>';
                      echo '<td>' . htmlspecialchars($khachhang['so_dien_thoai']) . '</td>';
                      echo '<td>' . htmlspecialchars($khachhang['dia_chi']) . '</td>';
                      echo '<td>';
                      echo '<div class="btn-group" role="group" aria-label="Actions">';
                      echo '<a href="xemKhachHang.php?ma_khach_hang=' . htmlspecialchars($khachhang['ma_khach_hang']) . '" 
                             class="btn btn-info btn-sm">
                             <i class="fas fa-eye"></i> Xem
                            </a>';
                      echo '<form method="POST" action="xoaKhachHang.php" style="display:inline;">
                              <input type="hidden" name="product_id" value="' . htmlspecialchars($khachhang['ma_khach_hang']) . '">
                              <button type="submit" class="btn btn-danger btn-sm" 
                                      onclick="return confirm(\'Bạn có chắc chắn muốn xóa khách hàng này không?\')">
                                <i class="fas fa-trash-alt"></i> Xóa
                              </button>
                            </form>';
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

  <!-- Các thư viện JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>
