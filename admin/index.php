<?php
  session_start();
  include "./dao/user.php";
  if(isset($_POST["login"])){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $user = checkuser($username, $password);
    if(isset($user)&&(is_array($user))&&(count($user)>0)){
      extract($user);
      if($role==1){
        $_SESSION['s_user']=$user;
        header('location: dashboard.php');
      }else{
        $tb="Username hoặc Password đã sai";
      }
    }
  }
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../admin/assets/css/login.css">

  
</head>
<body>

  <div class="login-box">
    <div class="login-logo">
      <img src="./images/logo2.jpg" alt="Admin Logo" class="img-circle">
    </div>

    <form action="index.php" method="post">
      <div class="form-group">
        <label for="username">Tên Đăng Nhập</label>
        <input type="text" placeholder="Nhập tên đăng nhập" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <input type="password" placeholder="Nhập mật khẩu" name="password" required>
      </div>

      <?php
        if(isset($tb) && ($tb != "")){
          echo "<div class='error-message'>$tb</div>";
        }
      ?>

      <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>

      <div class="forgot-password">
        <a href="#">Quên mật khẩu?</a>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>
