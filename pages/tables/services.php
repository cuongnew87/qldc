<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách dịch vụ</title>

    <?php
    include('../../components/header_scripts.php');
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <script type="text/javascript">
        let branch_id = 1;
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('branch_id')) {
                branch_id = urlParams.get('branch_id');
            }

            var selectBranch = document.getElementById("selectBranch");
                selectBranch.value = branch_id;
                var text = selectBranch.options[selectBranch.selectedIndex].text;
                document.getElementById("branchName").innerHTML = text;
        };
    </script>
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
                            <h1>Danh sách dịch vụ</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách dân cư</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Chọn khu nhà</label>
                                <select id="selectBranch" class="custom-select" onchange="changeBranch()">
                                    <option value="1">Tòa chung cư</option>
                                    <option value="2">Khu nhà phố</option>
                                    <option value="3">Biệt thự</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách dịch vụ của <span id="branchName"><span></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên dịch vụ</th>
                                                <th>Thuộc tòa nhà</th>
                                                <th>Giá tiền</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $branch_id = 1;
                                            $index = 1;
                                            $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
                                            $url = $base_url . $_SERVER["REQUEST_URI"];
                                            $parts = parse_url($url);
                                            if (isset($parts['query'])) {
                                                parse_str($parts['query'], $query);
                                                $branch_id = $query['branch_id'];
                                            }

                                            // Create connection
                                            $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                            // Check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            $sql = "SELECT * FROM `utilities_building`, `utilities`, `buildings`, `branches`
                                            WHERE `utilities_building`.`bldid` = `buildings`.`bldid`
                                            AND `utilities`.`utltid` = `utilities_building`.`utltid`
                                            AND `branches`.`branch_id` = `buildings`.`bldid`
                                            AND `branches`.`branch_id` =" . $branch_id;
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $index; $index++; ?></td>
                                                    <td><?php echo $row['utlt_name']; ?></td>
                                                    <td><?php echo $row['bld_name']; ?></td>
                                                    <td><?php echo $row['utlt_cost']; ?></td>
                                                    <td>
                                                        <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL ?>pages/tables/detail/service.php?service_id=<?php echo $row['utltid']; ?>"><i class="fa fa-eye"></i></a>
                                                        <a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="#" data-original-title="Edit"><i class="fa fa-pen"></i></a>
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

        function changeBranch() {
            var selectBranch = document.getElementById("selectBranch");
            var text = selectBranch.options[selectBranch.selectedIndex].text;
            var value = selectBranch.options[selectBranch.selectedIndex].value;
            document.getElementById("branchName").innerHTML = text;
            window.location.replace("<?php echo WEB_URL ?>pages/tables/services.php?branch_id=" + value);
        }
    </script>
</body>

</html>