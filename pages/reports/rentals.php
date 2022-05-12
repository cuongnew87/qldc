<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Chi phí</title>

    <?php
    include('../../components/header_scripts.php');
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        include('../../components/navbar.php');
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        include('../../components/main_sidebar_container.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Danh sách hóa đơn</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách hóa đơn</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                                    <h3 class="card-title">Danh sách hóa đơn</h3>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Thêm mới hóa đơn</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên tòa nhà</th>
                                                <th>Phòng</th>
                                                <th>Tổng tiền</th>
                                                <th>Ngày trả tiền</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;

                                            // Create connection
                                            $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                            // Check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            $sql = "SELECT * FROM bills, contracts, apartments, buildings WHERE bills.aid = apartments.aid AND contracts.aid = apartments.aid AND apartments.bldid = buildings.bldid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td><?php echo $row['bld_name']; ?></td>
                                                        <td><?php echo $row['a_name']; ?></td>
                                                        <td><?php echo $row['total']; ?></td>
                                                        <td><?php echo $row['bill_paydate']; ?></td>
                                                        <td>
                                                            <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteFloor(12);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Thêm mới hóa đơn
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="apartment">Chọn phòng</label>
                                <select name="apartment" id="selectApartment" class="custom-select">
                                    <?php
                                    // Create connection
                                    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM apartments, buildings WHERE apartments.bldid = buildings.bldid AND r_status = 1";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <option value="<?php echo $row['aid'] ?>"><?php echo $row['a_name'] ?> (<?php echo $row['bld_name'] ?>)</option>
                                    <?php
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">Ngày trả</label>
                                <input id="date" type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="addNewBill()">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include('../../components/footer.php');
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php
    include('../../components/footer_scripts.php');
    ?>
    <!-- DataTables -->
    <script src="<?php echo WEB_URL ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

        function addNewBill(){
            $.ajax({
                url: "add_rentals.php",
                type: "POST",
                data: {
                    rentalApartment: document.getElementById("selectApartment").value,
                    rentalDate: document.getElementById("date").value,
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        location.reload();
                        console.log("data edit successfully");
                    } else {
                        console.log("data not added successfully");
                        console.log(result);
                    }
                }
            });
        }
    </script>
</body>

</html>