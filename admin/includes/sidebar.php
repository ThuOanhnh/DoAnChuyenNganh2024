<?php
// Lấy tên trang hiện tại
$currentPage = basename($_SERVER['REQUEST_URI']);

?>
<!-- CDN for AdminLTE and Font Awesome -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayScrollbars/css/OverlayScrollbars.min.css">
<link rel="stylesheet" href="style.css">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
  <img src="images/adminlaptop.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
  style="opacity: .8">
    <span class="brand-text font-weight-light">ADMIN</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="images/iconlaptop.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Laptop Store</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link <?= $currentPage == "dashboard.php" ? "active": "" ?>">
            <i class="nav-icon ion ion-ios-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Quản lý sản phẩm -->
        <li class="nav-item">
          <a href="quanlysanpham.php" class="nav-link  <?= $currentPage == "quanlysanpham.php" ? "active": "" ?>">
            <i class="nav-icon fas fa-heart"></i>
            <p>Quản lý sản phẩm</p>
          </a>
        </li>

        <!-- Quản lý khách hàng -->
        <li class="nav-item">
          <a href="quanlykhachhang.php" class="nav-link <?= $currentPage == "quanlykhachhang.php" ? "active": "" ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Quản lý khách hàng</p>
          </a>
        </li>

        <!-- Quản lý đơn hàng -->
        <li class="nav-item">
          <a href="quanlydonhang.php" class="nav-link <?= $currentPage == "quanlydonhang.php" ? "active": "" ?>">
            <i class="nav-icon fas fa-gift"></i>
            <p>Quản lý đơn hàng</p>
          </a>
        </li>

         <!-- Quản lý thống kê-->
         <li class="nav-item">
          <a href="quanlythongke.php" class="nav-link <?= $currentPage == "quanlythongke.php" ? "active": "" ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            
            <p>Quản lý thống kê</p>
          </a>
        </li>
        <!-- Đăng ký -->
        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-arrow-circle-right"></i>
            <p>Đăng xuất</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
