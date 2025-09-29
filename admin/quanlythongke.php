<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

$thongkeTrangThai = [];
$searchTrangThai = '';
$chartData = []; // Dữ liệu cho biểu đồ

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Lấy giá trị trạng thái từ form
    $searchTrangThai = $_POST['trang_thai'];
    $sql = "SELECT trang_thai, COUNT(ma_don_hang) AS so_don_hang, SUM(tong_tien) AS tong_tien, SUM(tong_san_pham) AS tong_san_pham
            FROM donhang WHERE trang_thai = ? GROUP BY trang_thai";
    $thongkeTrangThai = selectSQL($sql, [$searchTrangThai]);
} else {
    // Lấy thống kê cho tất cả trạng thái
    $sql = "SELECT trang_thai, COUNT(ma_don_hang) AS so_don_hang, SUM(tong_tien) AS tong_tien, SUM(tong_san_pham) AS tong_san_pham
            FROM donhang GROUP BY trang_thai";
    $thongkeTrangThai = selectSQL($sql);
}

// Chuẩn bị dữ liệu biểu đồ
foreach ($thongkeTrangThai as $thongke) {
    $chartData[] = [
        'label' => $thongke['trang_thai'],
        'value' => $thongke['so_don_hang']
    ];
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý thống kê trạng thái đơn hàng</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Thêm Chart.js -->
  <style>
    .chart-container {
        display: flex;
        justify-content: center; /* Căn giữa ngang */
        align-items: center;   /* Căn giữa dọc */
        height: 400px;         /* Chiều cao khung */
    }
    canvas {
        max-width: 400px; /* Giới hạn chiều rộng biểu đồ */
        max-height: 400px; /* Giới hạn chiều cao biểu đồ */
    }
  </style>
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
              <h1>Quản lý thống kê đơn hàng</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="container-fluid">
  
          <!-- Bộ lọc -->
          <div class="card">
            <div class="card-header">
                <form class="form-inline" method="POST">
                    <select name="trang_thai" class="form-control mr-2">
                        <option value="">Chọn trạng thái</option>
                        <option value="Đang xử lý" <?= $searchTrangThai == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                        <option value="Đang giao" <?= $searchTrangThai == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                        <option value="Hoàn thành" <?= $searchTrangThai == 'Hoàn thành' ? 'selected' : '' ?>>Hoàn thành</option>
                    </select>
                    <button type="submit" name="search" class="btn btn-primary">Lọc</button>
                    
                </form>
            </div>
          </div>

          <!-- Bảng Thống kê -->
          <div class="card">
            <div class="card-body">
              <table id="statisticsTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Trạng thái</th>
                    <th>Số đơn hàng</th>
                    <th>Tổng sản phẩm</th>
                    <th>Tổng tiền</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    if (empty($thongkeTrangThai)) {
                        echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu thống kê nào.</td></tr>";
                    } else {
                        foreach ($thongkeTrangThai as $thongke) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($thongke['trang_thai']) . '</td>';
                            echo '<td>' . htmlspecialchars($thongke['so_don_hang']) . '</td>';
                            echo '<td>' . htmlspecialchars($thongke['tong_san_pham']) . '</td>';
                            echo '<td>' . number_format($thongke['tong_tien'], 0, ',', '.') . ' VND</td>';
                            echo '</tr>';
                        }
                    }
                ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Biểu đồ -->
          <div class="card">
            <div class="card-body">
              <div class="chart-container">
                <canvas id="orderStatusChart"></canvas>
              </div>
            </div>
          </div>

        </div>
        <div class="card-footer">
          <a href="quanlythongke.php" class="btn btn-primary">Quay lại</a>    
        </div>
      </section>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <!-- Vẽ biểu đồ -->
  <script>
    // Dữ liệu từ PHP
    const chartData = <?php echo json_encode($chartData); ?>;

    // Trích xuất nhãn và giá trị từ dữ liệu PHP
    const labels = chartData.map(data => data.label);
    const values = chartData.map(data => data.value);

    // Vẽ biểu đồ
    const ctx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(ctx, {
        type: 'pie', // Loại biểu đồ
        data: {
            labels: labels,
            datasets: [{
                label: 'Số đơn hàng theo trạng thái',
                data: values,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right', // Đặt chú thích nằm ngang bên phải
                }
            }
        }
    });
  </script>
  
</body>
</html>
