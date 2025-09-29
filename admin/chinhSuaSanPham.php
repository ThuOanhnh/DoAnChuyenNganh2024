<?php
include('../admin/config/connect.php'); // Kết nối CSDL
$conn = connectdb();

$sanpham = null; // Dữ liệu sản phẩm
$error = ''; // Biến lưu thông báo lỗi

// Lấy thông tin sản phẩm dựa trên ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sanpham WHERE ma_san_pham = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $sanpham = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Kiểm tra nếu sản phẩm không tồn tại
if (!$sanpham) {
    die("Sản phẩm không tồn tại.");
}

// Khởi tạo dữ liệu ban đầu từ cơ sở dữ liệu
$ten_san_pham = $sanpham['ten_san_pham'];
$mo_ta = $sanpham['mo_ta'];
$gia = $sanpham['gia'];
$so_luong_ton = $sanpham['so_luong_ton'];
$anh_url = $sanpham['anh_url'];

// Cập nhật sản phẩm khi nhấn nút Lưu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_san_pham = $_POST['ten_san_pham'];
    $mo_ta = $_POST['mo_ta'];
    $gia = $_POST['gia'];
    $so_luong_ton = $_POST['so_luong_ton'];
    $anh_moi = $_FILES['anh_url']['name'];

    // Kiểm tra và tải lên ảnh (nếu có)
    if (!empty($anh_moi)) {
        // Lấy đuôi file
        $file_extension = strtolower(pathinfo($anh_moi, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file
        $allowed_extensions = ['png', 'jpg', 'jpeg'];
        if (!in_array($file_extension, $allowed_extensions)) {
            $error = "Vui lòng chọn đúng file ảnh (png, jpg, jpeg).";
        } else {
            $target_dir = "./images/";
            $target_file = $target_dir . basename($anh_moi);
            move_uploaded_file($_FILES['anh_url']['tmp_name'], $target_file);
            $anh_url = $anh_moi; // Cập nhật đường dẫn ảnh mới
        }
    }

    // Nếu không có lỗi, cập nhật dữ liệu vào CSDL
    if (empty($error)) {
        $sql = "UPDATE sanpham 
                SET ten_san_pham = :ten_san_pham, mo_ta = :mo_ta, gia = :gia, so_luong_ton = :so_luong_ton, anh_url = :anh_url 
                WHERE ma_san_pham = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'ten_san_pham' => $ten_san_pham,
            'mo_ta' => $mo_ta,
            'gia' => $gia,
            'so_luong_ton' => $so_luong_ton,
            'anh_url' => $anh_url,
            'id' => $id
        ]);

        // Chuyển hướng về trang quản lý sau khi cập nhật
        header('Location: quanlysanpham.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chỉnh sửa sản phẩm</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Chỉnh sửa sản phẩm</h2>

    <!-- Hiển thị thông báo lỗi -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="ten_san_pham">Tên sản phẩm</label>
        <input type="text" name="ten_san_pham" class="form-control" value="<?php echo htmlspecialchars($ten_san_pham); ?>" required>
      </div>
      <div class="form-group">
        <label for="mo_ta">Mô tả</label>
        <textarea name="mo_ta" class="form-control" required><?php echo htmlspecialchars($mo_ta); ?></textarea>
      </div>
      <div class="form-group">
        <label for="gia">Giá</label>
        <input type="number" name="gia" class="form-control" value="<?php echo htmlspecialchars($gia); ?>" required>
      </div>
      <div class="form-group">
        <label for="so_luong_ton">Số lượng tồn</label>
        <input type="number" name="so_luong_ton" class="form-control" value="<?php echo htmlspecialchars($so_luong_ton); ?>" required>
      </div>
      <div class="form-group">
        <label for="anh_url">Ảnh sản phẩm</label>
        <input type="file" name="anh_url" class="form-control">
        <img src="./images/<?php echo htmlspecialchars($anh_url); ?>" alt="Ảnh sản phẩm" style="width: 100px; margin-top: 10px;">
      </div>
      <button type="submit" class="btn btn-primary">Lưu</button>
      <a href="quanlysanpham.php" class="btn btn-secondary">Hủy</a>
    </form>
  </div>
</body>
</html>
