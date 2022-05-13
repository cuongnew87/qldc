<?php
    session_start();
    if(!isset($_SESSION['username']) && !isset($_SESSION['role'])){
        header("Location: " . WEB_URL ."pages/others/login.php");
    }

    if($_SESSION['role'] != 1)
    header("Location: " . WEB_URL ."pages/others/login.php");

    function activeLi($file_name)
    {
        if (strpos($_SERVER['REQUEST_URI'], $file_name)) echo 'active';
    }

    function menuOpen($file_name)
    {
        if (strpos($_SERVER['REQUEST_URI'], $file_name)) echo 'menu-open';
    }

    // Create connection
    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = mysqli_query($conn, "SELECT * FROM residents WHERE rsd_mail = '" . $_SESSION['email'] . "'");
    $data = mysqli_fetch_array($result);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="<?php echo WEB_URL ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo WEB_URL ?>dist/img/tennants/<?php echo $data['rsd_image'] ?>" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['username']; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
                <li class="nav-item <?php menuOpen('index') ?>">
                    <a href="#" class="nav-link <?php activeLi('index') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/index.php" class="nav-link <?php activeLi('index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trang chủ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">THÔNG TIN</li>
                <li class="nav-item <?php menuOpen('pages/tables') ?>">
                    <a href="#" class="nav-link <?php activeLi('pages/tables') ?>">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Bảng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/members.php" class="nav-link <?php activeLi('members.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách thành viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/profile.php" class="nav-link <?php activeLi('profile.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thông tin cá nhân</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/services.php" class="nav-link <?php activeLi('services.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/apartment.php" class="nav-link <?php activeLi('apartment.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thông tin căn hộ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?php menuOpen('pages/reports') ?>">
                    <a href="#" class="nav-link <?php activeLi('pages/reports') ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Thống kê
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/complain.php" class="nav-link <?php activeLi('complain.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Khiếu nại</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>role_1/bill.php" class="nav-link <?php activeLi('pages/reports/rentals.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hóa đơn</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">KHÁC</li>
                <li class="nav-item">
                    <a href="<?php echo WEB_URL ?>role_1/contact.php" class="nav-link <?php activeLi('contact.php') ?>">
                    <i class="nav-icon far fa-circle"></i>
                    <p class="text">Liên hệ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo WEB_URL ?>pages/others/login.php" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p class="text">Đăng xuất</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>