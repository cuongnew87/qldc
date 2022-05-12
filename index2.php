<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Khu nhà phố</title>

    <?php
  include('components/header_scripts.php');
  ?>

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo WEB_URL?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo WEB_URL?>plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo WEB_URL?>plugins/jqvmap/jqvmap.min.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo WEB_URL?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo WEB_URL?>plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo WEB_URL?>plugins/summernote/summernote-bs4.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php
    include('components/navbar.php');
    ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
    include('components/main_sidebar_container.php');
    ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Khu nhà phố</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Khu nhà phố</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <?php
                $num_building = 0;
                $num_resident = 0;
                $num_complain = 0;
                // Create connection
                $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT count(*) AS num_building FROM buildings WHERE branch_id = 2";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $num_building = $row['num_building'];
                    }
                }

                $sql = "SELECT count(*) AS num_resident FROM residents, buildings WHERE buildings.bldid = residents.bldid AND branch_id = 2";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $num_resident = $row['num_resident'];
                    }
                }

                $sql = "SELECT count(*) AS num_complain FROM complains, buildings, apartments WHERE buildings.bldid = apartments.bldid AND complains.aid = apartments.aid AND branch_id = 2";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $num_complain = $row['num_complain'];
                    }
                }
                ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo $num_building ?></h3>

                                    <p>Tổng số khu nhà phố</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-home"></i>
                                </div>
                                <a href="<?php echo WEB_URL ?>pages/tables/buildings.php?branch_id = 2"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>53$</h3>

                                    <p>Tổng chi phí thuê</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo $num_resident ?></h3>

                                    <p>Số dân cư</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="<?php echo WEB_URL ?>pages/tables/tennants.php?branch_id = 2"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo $num_complain ?></h3>

                                    <p>Số lần phản hồi</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-chatbox"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-7 connectedSortable">
                                <!-- DIRECT CHAT -->
                                <div class="card direct-chat direct-chat-primary direct-chat-contacts-open">
                                    <div class="card-header">
                                        <h3 class="card-title">Phản hồi của người thuê</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages">
                                        </div>
                                        <!--/.direct-chat-messages-->

                                        <!-- Contacts are loaded here -->
                                        <div class="direct-chat-contacts">
                                            <ul class="contacts-list">
                                                <?php
                                                    $sql = "SELECT * FROM complains, buildings, apartments WHERE buildings.bldid = apartments.bldid AND complains.aid = apartments.aid AND branch_id = 2 LIMIT 10";
                                                    $result = $conn->query($sql);
                                    
                                                    if ($result->num_rows > 0) {
                                                        // output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                <li>
                                                    <a href="#">
                                                        <img class="contacts-list-img" src="<?php echo WEB_URL ?>dist/img/tennants/user-default.png"
                                                            alt="User Avatar" />

                                                        <div class="contacts-list-info">
                                                            <span class="contacts-list-name">
                                                                <?php echo $row['a_name'] ?>
                                                                <small
                                                                    class="contacts-list-date float-right"><?php echo $row['cpl_date'] ?></small>
                                                            </span>
                                                            <span class="contacts-list-msg"><?php echo $row['cpl_complain'] ?></span>
                                                        </div>
                                                        <!-- /.contacts-list-info -->
                                                    </a>
                                                </li>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                            <!-- /.contacts-list -->
                                        </div>
                                        <!-- /.direct-chat-pane -->
                                    </div>
                                </div>
                                <!--/.direct-chat -->
                                <!-- /.card -->
                            </section>
                            <!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">

                            <!-- Calendar -->
                            <div class="card bg-gradient-success">
                                <div class="card-header border-0">
                                    <h3 class="card-title">
                                        <i class="far fa-calendar-alt"></i>
                                        Calendar
                                    </h3>
                                    <!-- tools card -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-success btn-sm"
                                            data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body pt-0">
                                    <!--The calendar -->
                                    <div id="calendar" style="width: 100%"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
    include('components/footer.php');
    ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php
  include('components/footer_scripts.php');
  ?>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo WEB_URL?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- ChartJS -->
    <script src="<?php echo WEB_URL?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo WEB_URL?>plugins/sparklines/sparkline.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo WEB_URL?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo WEB_URL?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo WEB_URL?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo WEB_URL?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?php echo WEB_URL?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?php echo WEB_URL?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo WEB_URL ?>dist/js/pages/dashboard.js"></script>
</body>
<?php $conn->close(); ?>
</html>