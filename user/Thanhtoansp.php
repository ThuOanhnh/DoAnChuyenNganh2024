<?php

include '../connect.php';
$conn = connectdb();

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
<style>
    .paypal_img {
        width: 90%;
        margin: auto;
        display: block;
    }

    body {
        overflow-x: hidden;
    }
</style>

<body>

    <!-- code php truy cập đến mã khách hàng-->
    <?php

    $ip = 1;
    try {

        // Chuẩn bị câu lệnh SQL
        $get_user = "SELECT * FROM khachhang WHERE ip = :ip";
        $stmt = $conn->prepare($get_user);
        // Gán giá trị tham số và thực thi truy vấn
        $stmt->bindParam(':ip', $ip, PDO::PARAM_INT);
        $stmt->execute();
        // Lấy kết quả
        $run_query = $stmt->fetch(PDO::FETCH_ASSOC);
        // Nếu tìm thấy kết quả, gán giá trị cho biến $ip
        if ($run_query) {
            $ip = $run_query['ip'];
        } else {
            echo "Không tìm thấy dữ liệu.";
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }

    ?>
    <div class="container">
        <h2 class="text-center text-info">Hình thức thanh toán</h2>
        <div class="row d-flex justify-content-center align-items-center my-5">
            <div class="col-md-6">
                <a href="https://www.paypal.com" target="_blank">
                    <img src=".././image/paypal-la-gi.jpg" alt="" class="paypal_img">
                </a>
            </div>
            <div class="col-md-6">
                <a href="order.php?ma_khach_hang=<?php echo $ip; ?>">
                    <h2 class="text-center">Thanh toán khi nhận hàng</h2>
                </a>
            </div>
        </div>
    </div>
</body>

</html>