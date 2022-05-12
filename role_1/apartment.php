<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Chi tiết tòa nhà</title>

    <?php
    include('header_scripts.php');
    ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Main Sidebar Container -->
        <?php
        include('main_sidebar_container.php');
        ?>

        <?php

        // Create connection
        $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = mysqli_query($conn, 
        "SELECT * FROM `residents`, `apartments`, `buildings`, `apartment_type`, `contracts`
        WHERE `residents`.`aid` = `apartments`.`aid`
        AND `residents`.`bldid` = `apartments`.`bldid`
        AND `apartments`.`bldid` = `buildings`.`bldid`
        AND `apartments`.`atype_id` = `apartment_type`.`atype_id`
        AND `contracts`.`aid` = `apartments`.`aid`
        AND `residents`.`rsd_mail` = '". $_SESSION['email'] ."'");
        $data = mysqli_fetch_array($result);
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thông tin chi tiết căn phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Thông tin chi tiết căn phòng</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div id="success-modal" class="alert alert-success d-none" role="alert">
                        Update building information success!
                    </div>
                    <div id="danger-modal" class="alert alert-danger d-none" role="alert">
                        Update building information failed!
                    </div>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin căn phòng</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Tên tòa nhà</label>
                                            <input id="buildingName" type="text" class="form-control" readonly value="<?php echo $data['bld_name'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input id="buildingAddress" type="text" class="form-control" readonly value="<?php echo $data['bld_address'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Tên căn hộ</label>
                                            <input id="buildingName" type="text" class="form-control" readonly value="<?php echo $data['a_name'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Giá tiền cho thuê/mua</label>
                                            <input id="buildingName" type="text" class="form-control" readonly value="<?php if($data['rent_fee'] != 0) echo $data['rent_fee'] . "đ"; else echo $data['buy_fee'] . "đ"; ?>" />
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                        <!--/.col (left) -->

                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Hình ảnh</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <img id="edit-image" src="<?php echo WEB_URL ?>dist/img/buildings/<?php echo $data['bld_image'] ?>" Width="100%" Height="100%" />
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php
        include('footer.php');
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php $conn->close(); ?>
    <?php
    include('footer_scripts.php');
    ?>
</body>

</html>