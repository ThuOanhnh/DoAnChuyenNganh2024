
<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/connect.php'); // Gọi file kết nối CSDL

// Khởi tạo biến
$search_query = ''; // Tìm kiếm theo từ khóa
$search_by_code = ''; // Tìm kiếm theo mã sản phẩm
$sanphams = []; // Mảng lưu danh sách sản phẩm tìm kiếm

$conn = connectdb(); // Kết nối cơ sở dữ liệu

// Xử lý tìm kiếm theo từ khóa
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = trim($_GET['search']); // Lấy từ khóa từ form
    $sql = "SELECT * FROM sanpham WHERE tu_khoa LIKE :search"; // Truy vấn tìm kiếm theo từ khóa
    $stmt = $conn->prepare($sql);
    $stmt->execute(['search' => '%' . $search_query . '%']);
    $sanphams = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
} 
// Xử lý tìm kiếm theo mã sản phẩm
elseif (isset($_GET['search_by_code']) && !empty($_GET['search_by_code'])) {
    $search_by_code = trim($_GET['search_by_code']); // Lấy mã sản phẩm từ form
    $sql = "SELECT * FROM sanpham WHERE ma_san_pham LIKE :search_code"; // Truy vấn tìm kiếm theo mã sản phẩm
    $stmt = $conn->prepare($sql);
    $stmt->execute(['search_code' => '%' . $search_by_code . '%']);
    $sanphams = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
} 
// Trường hợp không tìm kiếm, hiển thị tất cả sản phẩm
else {
    $sql = "SELECT * FROM sanpham"; // Truy vấn hiển thị tất cả sản phẩm
    $stmt = $conn->prepare($sql);
    $stmt->execute(); // Thực thi truy vấn
    $sanphams = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
}

$conn = null; // Đóng kết nối
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý sản phẩm</title>
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
              <h1>Quản lý sản phẩm</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Form tìm kiếm theo từ khóa -->
          <div class="card-header">
            <form class="form-inline" method="GET" action="quanlysanpham.php">
              <input 
                type="text" 
                name="search" 
                class="form-control mr-2" 
                placeholder="Nhập từ khóa sản phẩm" 
                value="<?php echo htmlspecialchars($search_query); ?>"> 

              <button type="submit" class="btn btn-primary">Tìm kiếm theo từ khóa</button>
            </form>
          </div>

          <!-- Form tìm kiếm theo mã sản phẩm -->
          <div class="card-header mt-3">
            <form class="form-inline" method="GET" action="quanlysanpham.php">
              <input 
                type="text" 
                name="search_by_code" 
                class="form-control mr-2" 
                placeholder="Nhập mã sản phẩm" 
                value="<?php echo htmlspecialchars($search_by_code); ?>"> 

              <button type="submit" class="btn btn-primary">Tìm kiếm theo mã</button>
              <a href="themSanPham.php" class="btn btn-success ml-2">Thêm sản phẩm</a>
            </form>
          </div>

          <!-- Bảng danh sách sản phẩm -->
          <div class="card">
            <div class="card-body">
              <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Số lượng tồn</th>
                    <th>Ảnh</th>
                    <th style="width: 10%;">Từ khóa</th>
                    <th style="width: 15%;">Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($sanphams)) {
                      foreach ($sanphams as $sanpham) {
                          echo '<tr>';
                          echo '<td>' . htmlspecialchars($sanpham['ma_san_pham']) . '</td>';
                          echo '<td>' . htmlspecialchars($sanpham['ten_san_pham']) . '</td>';
                          echo '<td>' . htmlspecialchars($sanpham['mo_ta']) . '</td>';
                          echo '<td>' . htmlspecialchars(number_format($sanpham['gia'], 0, ',', '.')) . ' VND</td>';
                          echo '<td>' . htmlspecialchars($sanpham['so_luong_ton']) . '</td>';
                          echo '<td><img src="./images/' . htmlspecialchars($sanpham['anh_url']) . '" alt="Ảnh sản phẩm" style="width: 50px; height: 50px;"></td>';
                          echo '<td>' . htmlspecialchars($sanpham['tu_khoa']) . '</td>'; 
                          echo '<td>';
                          echo '<div class="btn-group" role="group" aria-label="Actions">';
                          echo '<a href="chinhSuaSanPham.php?id=' . htmlspecialchars($sanpham['ma_san_pham']) . '" 
                                 class="btn btn-info btn-sm" >
                                 <i class="fas fa-edit"></i> Chỉnh sửa
                                </a>';
                          echo '<form method="POST" action="xoaSanPham.php" style="display:inline;">
                                  <input type="hidden" name="product_id" value="' . htmlspecialchars($sanpham['ma_san_pham']) . '">
                                  <button type="submit" class="btn btn-danger btn-sm" 
                                          onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này không?\')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                  </button>
                                </form>';
                          echo '</div>';
                          echo '</td>';
                          echo '</tr>';
                      }
                  } else {
                      echo '<tr><td colspan="8">Không tìm thấy sản phẩm phù hợp.</td></tr>';
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  
</body>
</html>
