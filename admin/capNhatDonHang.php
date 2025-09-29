<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

// Lấy mã đơn hàng từ URL
if (!isset($_GET['ma_don_hang'])) {
  echo "Mã đơn hàng không hợp lệ!";
  exit;
}

$maDonHang = $_GET['ma_don_hang'];

// Lấy thông tin đơn hàng từ cơ sở dữ liệu
$sql = "SELECT * FROM donhang WHERE ma_don_hang = ?";
$donhang = selectSQL($sql, [$maDonHang]);

if (!$donhang) {
  echo "Đơn hàng không tồn tại!";
  exit;
}

$donhang = $donhang[0]; // Lấy bản ghi đầu tiên

// Xử lý cập nhật đơn hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $maKhachHang = $_POST['ma_khach_hang'];
  $ngayDat = $_POST['ngay_dat'];
  $tongsanpham = $_POST['tong_san_pham'];
  $tongtien = $_POST['tong_tien'];
  $trangThai = $_POST['trang_thai'];
  $sohoadon = $_POST['so_hoa_don'];

  // Cập nhật thông tin đơn hàng (trừ mã đơn hàng)
  $sqlUpdate = "UPDATE donhang 
                SET ma_khach_hang = ?, ngay_dat = ?, tong_san_pham = ?, tong_tien = ?, so_hoa_don = ?, trang_thai = ?  
                WHERE ma_don_hang = ?";
  $params = [$maKhachHang, $ngayDat, $tongsanpham, $tongtien, $sohoadon, $trangThai, $maDonHang];

  if (execSQL($sqlUpdate, $params)) {
    echo "<script>alert('Cập nhật đơn hàng thành công!'); window.location.href='quanlydonhang.php';</script>";
  } else {
    echo "<script>alert('Cập nhật thất bại!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cập nhật đơn hàng</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include_once('./includes/sidebar.php'); ?>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Cập nhật đơn hàng</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <form method="POST">
                <!-- Mã đơn hàng (readonly để không cho phép chỉnh sửa) -->
                <div class="form-group">
                  <label for="ma_don_hang">Mã đơn hàng</label>
                  <input type="text" id="ma_don_hang" name="ma_don_hang" 
                         value="<?= htmlspecialchars($donhang['ma_don_hang']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Mã khách hàng -->
                <div class="form-group">
                  <label for="ma_khach_hang">Mã khách hàng</label>
                  <input type="text" id="ma_khach_hang" name="ma_khach_hang" 
                         value="<?= htmlspecialchars($donhang['ma_khach_hang']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Ngày đặt -->
                <div class="form-group">
                  <label for="ngay_dat">Ngày đặt</label>
                  <input type="datetime-local" id="ngay_dat" name="ngay_dat" 
                         value="<?= htmlspecialchars($donhang['ngay_dat']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Tổng sản phẩm -->
                <div class="form-group">
                  <label for="tong_san_pham">Tổng sản phẩm</label>
                  <input type="number" id="tong_san_pham" name="tong_san_pham" 
                         value="<?= htmlspecialchars($donhang['tong_san_pham']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Tổng tiền -->
                <div class="form-group">
                  <label for="tong_tien">Tổng tiền</label>
                  <input type="text" id="tong_tien" name="tong_tien" 
                         value="<?= htmlspecialchars($donhang['tong_tien']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Số hóa đơn -->
                <div class="form-group">
                  <label for="so_hoa_don">Số hóa đơn</label>
                  <input type="number" id="so_hoa_don" name="so_hoa_don" 
                         value="<?= htmlspecialchars($donhang['so_hoa_don']) ?>" 
                         class="form-control" readonly>
                </div>

                <!-- Trạng thái -->
                <div class="form-group">
                  <label for="trang_thai">Trạng thái</label>
                  <select id="trang_thai" name="trang_thai" class="form-control">
                    <option value="Đang xử lý" <?= $donhang['trang_thai'] == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                    <option value="Đang giao" <?= $donhang['trang_thai'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                    <option value="Hoàn thành" <?= $donhang['trang_thai'] == 'Hoàn thành' ? 'selected' : '' ?>>Hoàn thành</option>
                  </select>
                </div>

                <!-- Nút cập nhật -->
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="quanlydonhang.php" class="btn btn-secondary">Hủy</a>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>

</html>
