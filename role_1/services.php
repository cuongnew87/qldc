<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách dịch vụ</title>

    <?php
    include('header_scripts.php');
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        <?php
        include('main_sidebar_container.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Danh sách dịch vụ</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách dịch vụ</li>
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
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên dịch vụ</th>
                                                <th>Giá tiền</th>
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

                                            $sql = "SELECT `utilities`.*,`utilities_building`.`register`,`utilities_building`.`utlt_cost` FROM `residents`,`contracts`,`utilities`,`utilities_building` 
                                            WHERE `residents`.`rsdid` = `contracts`.`rsdid` 
                                            AND `utilities_building`.`utltid` = `utilities`.`utltid` 
                                            AND `utilities_building`.`register` = 1
                                            AND `residents`.`rsd_mail` = '". $_SESSION['email'] ."' ";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $index;
                                                        $index++; ?></td>
                                                    <td id="<?php echo $row['utltid']; ?>"><?php echo $row['utlt_name']; ?></td>
                                                    <td><?php echo $row['utlt_cost']; ?><sup>đ</sup></td>
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

    <?php
    include('footer_scripts.php');
    ?>
    <!-- DataTables -->
    <script src="<?php echo WEB_URL ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo WEB_URL ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Page specific script -->
    <script>
        let service_id = 0;
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

        function editService(id) {
            document.getElementById("name").value = document.getElementById(id).innerHTML;
            document.getElementById("modalButton").innerHTML = "Thay đổi";
            service_id = id;
        }

        function addNewService() {
            document.getElementById("name").value = "";
            document.getElementById("modalButton").innerHTML = "Thêm mới";
            service_id = 0;
        }

        function service() {
            $.ajax({
                url: "service.php",
                type: "POST",
                data: {
                    serviceId: service_id,
                    serviceName: document.getElementById("name").value,
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        location.reload();
                        console.log("change data successfully");                        
                    } else {
                        console.log("data not added successfully");
                        console.log(result);
                    }
                }
            });
        }

        function deleteService(){
            $.ajax({
                url: "delete_service.php",
                type: "POST",
                data: {
                    serviceId: service_id,
                    serviceName: document.getElementById("name").value,
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        location.reload();
                        console.log("change data successfully");                        
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