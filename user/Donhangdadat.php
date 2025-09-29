<?php
// include '../connect.php';
// $conn = connectdb();

// session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LAPTOP007</title>
      <!-- bootstrap link -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <!-- font link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- font icon -->
</head>

<body>
      <?php
      
      $username = $_SESSION['username'];
      try {
            $stmt = $conn->prepare("SELECT * FROM khachhang WHERE ten_khach_hang = :username");

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                  $userid = $row['ma_khach_hang'];
                  // Sử dụng $userid nếu cần
            } else {
                  // Xử lý khi không tìm thấy người dùng
                  echo "Không tìm thấy khách hàng.";
            }
      } catch (PDOException $e) {
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
      }
      ?>
      <h3 class="text-center">Tất cả đơn hàng đã đặt</h3>
      <table class="table table-bordered mt-5">
            <thead class="bg_info">
                  <tr>
                        <th>Số thứ tự</th>
                        <th>Mã đơn hàng</th>
                        <th>Tổng tiền</th>
                        <th>Tổng sản phẩm</th>
                        <th>Ngày đặt</th>
                        <th>Số hóa đơn</th>
                        <th>Hoàn thành/Chưa hoàn thành</th>
                        <th>Trạng thái</th>
                  </tr>
            </thead>
            <tbody class="bg-secondary">
                  <?php
                  
                  $get_order_detail = "SELECT * FROM donhang WHERE ma_khach_hang IS NULL";
                  $stmt = $conn->prepare($get_order_detail);
                  $stmt->execute();

                  $stt = 1;
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $oid = $row['ma_don_hang'];
                        //$tongtien = $row['tong_tien'];
                        $tongtien = number_format($row['tong_tien'], 0, ',', '.') . ' VND';
                        $tongsp = $row['tong_san_pham'];
                        $sohoadon = $row['so_hoa_don'];
                        $ngaydat = $row['ngay_dat'];
                        $trangthai = $row['trang_thai'];
                        if($trangthai=='Đang xử lý'){
                              $trangthai='Chưa hoàn thành';
                        }else{
                              $trangthai='Hoàn thành';
                        }

                        echo "<tr>
            <td>$stt</td>
            <td>$oid</td>
            <td>$tongtien</td>
            <td>$tongsp</td>
            <td>$ngaydat</td>
            <td>$sohoadon</td>
            <td>$trangthai</td>
            <td><a href='xacnhan.php' >Xác nhận</a></td>
          </tr>";
                        $stt++;
                  }



                  ?>


            </tbody>
      </table>
</body>

</html>