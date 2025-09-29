<?php
include('config/connect.php'); // Kết nối CSDL

// Lấy ID khách hàng từ URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $conn = connectdb();
        // Truy vấn lấy thông tin khách hàng
        $sql = "SELECT * FROM khachhang WHERE ma_khach_hang = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $khachhang = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$khachhang) {
            echo "Khách hàng không tồn tại.";
            exit;
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
        exit;
    }
} else {
    echo "Không tìm thấy ID khách hàng.";
    exit;
}

// Xử lý cập nhật khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khach_hang = $_POST['ten_khach_hang'];
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];

    try {
        $sql = "UPDATE khachhang 
                SET ten_khach_hang = :ten_khach_hang, email = :email, mat_khau = :mat_khau, 
                    so_dien_thoai = :so_dien_thoai, dia_chi = :dia_chi
                WHERE ma_khach_hang = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'ten_khach_hang' => $ten_khach_hang,
            'email' => $email,
            'mat_khau' => $mat_khau,
            'so_dien_thoai' => $so_dien_thoai,
            'dia_chi' => $dia_chi,
            'id' => $id
        ]);

        // Chuyển hướng về trang quản lý khách hàng kèm thông báo
        session_start();
        $_SESSION['message'] = 'Cập nhật thông tin khách hàng thành công.';
        header('Location: quanlykhachhang.php');
        exit;
    } catch (Exception $e) {
        echo "Lỗi khi cập nhật: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chỉnh sửa khách hàng</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Chỉnh sửa thông tin khách hàng</h1>
    <form method="POST">
        <div class="form-group">
            <label for="ten_khach_hang">Tên khách hàng:</label>
            <input type="text" id="ten_khach_hang" name="ten_khach_hang" class="form-control" 
                   value="<?= htmlspecialchars($khachhang['ten_khach_hang']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($khachhang['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="mat_khau">Mật khẩu:</label>
            <input type="password" id="mat_khau" name="mat_khau" class="form-control" 
                   value="<?= htmlspecialchars($khachhang['mat_khau']) ?>" required>
        </div>
        <div class="form-group">
            <label for="so_dien_thoai">Số điện thoại:</label>
            <input type="text" id="so_dien_thoai" name="so_dien_thoai" class="form-control" 
                   value="<?= htmlspecialchars($khachhang['so_dien_thoai']) ?>" required>
        </div>
        <div class="form-group">
            <label for="dia_chi">Địa chỉ:</label>
            <textarea id="dia_chi" name="dia_chi" class="form-control" required><?= htmlspecialchars($khachhang['dia_chi']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="quanlykhachhang.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
