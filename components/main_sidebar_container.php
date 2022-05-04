<?php
    function activeLi($file_name)
    {
        if (strpos($_SERVER['REQUEST_URI'], $file_name)) echo 'active';
    }

    function menuOpen($file_name)
    {
        if (strpos($_SERVER['REQUEST_URI'], $file_name)) echo 'menu-open';
    }
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
                <img src="<?php echo WEB_URL ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
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
                            <a href="<?php echo WEB_URL ?>index.php" class="nav-link <?php activeLi('index.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tòa chung cư</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>index2.php" class="nav-link <?php activeLi('index2.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Khu nhà phố</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>index3.php" class="nav-link <?php activeLi('index3.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tòa biệt thự</p>
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
                            <a href="<?php echo WEB_URL ?>pages/tables/buildings.php" class="nav-link <?php activeLi('pages/tables/buildings.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách tòa nhà</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/tables/tennants.php" class="nav-link <?php activeLi('pages/tables/tennants.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách cư dân</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/tables/services.php" class="nav-link <?php activeLi('pages/tables/services.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/tables/apartments.php" class="nav-link <?php activeLi('pages/tables/apartments.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Căn hộ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/tables/contracts.php" class="nav-link <?php activeLi('pages/tables/contracts.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hợp đồng</p>
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
                            <a href="<?php echo WEB_URL ?>pages/reports/tenants.php" class="nav-link <?php activeLi('pages/reports/tenants.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dân cư</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/reports/apartments.php" class="nav-link <?php activeLi('pages/reports/apartments.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Căn hộ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo WEB_URL ?>pages/reports/rentals.php" class="nav-link <?php activeLi('pages/reports/rentals.php') ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chi phí</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">KHÁC</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
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