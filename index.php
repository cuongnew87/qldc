<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Tòa chung cư</title>

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
                            <h1 class="m-0 text-dark">Tòa chung cư</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Tòa chung cư</li>
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
                // Create connection
                $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT count(*) AS num_building FROM buildings WHERE branch_id = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $num_building = $row['num_building'];
                    }
                }

                $sql = "SELECT count(*) AS num_resident FROM residents, buildings WHERE buildings.bldid = residents.bldid AND branch_id = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $num_resident = $row['num_resident'];
                    }
                }

                $conn->close();
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

                                    <p>Tổng số tòa chung cư</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-home"></i>
                                </div>
                                <a href="<?php echo WEB_URL ?>pages/tables/buildings.php?branch_id=1"
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
                                <a href="<?php echo WEB_URL ?>pages/tables/tennants.php?branch_id=1"
                                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>65</h3>

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
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Chi phí cho thuê theo năm
                                    </h3>
                                    <div class="card-tools">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#revenue-chart"
                                                    data-toggle="tab">Area</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content p-0">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane active" id="revenue-chart"
                                            style="position: relative; height: 300px">
                                            <canvas id="revenue-chart-canvas" height="300"
                                                style="height: 300px"></canvas>
                                        </div>
                                        <div class="chart tab-pane" id="sales-chart"
                                            style="position: relative; height: 300px">
                                            <canvas id="sales-chart-canvas" height="300" style="height: 300px"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- DIRECT CHAT -->
                            <div class="card direct-chat direct-chat-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Phản hồi của người thuê</h3>

                                    <div class="card-tools">
                                        <span title="3 New Messages" class="badge badge-primary">3</span>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" title="Contacts"
                                            data-widget="chat-pane-toggle">
                                            <i class="fas fa-comments"></i>
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
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg"
                                                alt="message user image" />
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                Is this template really for free? That's unbelievable!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg"
                                                alt="message user image" />
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                You better believe it!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg"
                                                alt="message user image" />
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                Working with AdminLTE on a great new app! Wanna join?
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                                <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg"
                                                alt="message user image" />
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">I would love to.</div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->
                                    </div>
                                    <!--/.direct-chat-messages-->

                                    <!-- Contacts are loaded here -->
                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user1-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small
                                                                class="contacts-list-date float-right">2/28/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">How have you been? I
                                                            was...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user7-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Sarah Doe
                                                            <small
                                                                class="contacts-list-date float-right">2/23/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">I will be waiting for...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user3-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Nadia Jolie
                                                            <small
                                                                class="contacts-list-date float-right">2/20/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">I'll call you back at...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user5-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Nora S. Vans
                                                            <small
                                                                class="contacts-list-date float-right">2/10/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">Where is your new...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user6-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            John K.
                                                            <small
                                                                class="contacts-list-date float-right">1/27/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">Can I take a look at...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                            <li>
                                                <a href="#">
                                                    <img class="contacts-list-img" src="dist/img/user8-128x128.jpg"
                                                        alt="User Avatar" />

                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">
                                                            Kenneth M.
                                                            <small
                                                                class="contacts-list-date float-right">1/4/2015</small>
                                                        </span>
                                                        <span class="contacts-list-msg">Never mind I found...</span>
                                                    </div>
                                                    <!-- /.contacts-list-info -->
                                                </a>
                                            </li>
                                            <!-- End Contact Item -->
                                        </ul>
                                        <!-- /.contacts-list -->
                                    </div>
                                    <!-- /.direct-chat-pane -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <form action="#" method="post">
                                        <div class="input-group">
                                            <input type="text" name="message" placeholder="Type Message ..."
                                                class="form-control" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary">
                                                    Send
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-footer-->
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

</html>