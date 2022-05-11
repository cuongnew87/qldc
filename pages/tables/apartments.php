<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách các phòng</title>

    <?php
    include('../../components/header_scripts.php');
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <script type="text/javascript">
        let building_id = 1;
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('building_id')) {
                building_id = urlParams.get('building_id');
            }

            var selectBuilding = document.getElementById("selectBuilding");
            selectBuilding.value = building_id;
            var text = selectBuilding.options[selectBuilding.selectedIndex].text;
            document.getElementById("buildingName").innerHTML = text;
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
                            <h1>Danh sách các phòng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách các phòng</li>
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
                                <label>Chọn tòa nhà</label>
                                <select id="selectBuilding" class="custom-select" onchange="changeBuilding()">
                                    <?php
                                    // Create connection
                                    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM `buildings`";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                    ?>

                                            <option value="<?php echo $row['bldid']; ?>"><?php echo $row['bld_name']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Danh sách <span id="buildingName"><span></h3>

                                        <div>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="addNewApartment()">Thêm mới phòng</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên phòng</th>
                                                <th>Loại phòng</th>
                                                <th>Diện tích (m<sup>2</sup>)</th>
                                                <th>Cho thuê/ Được mua</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $building_id = 1;
                                            $index = 1;
                                            $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
                                            $url = $base_url . $_SERVER["REQUEST_URI"];
                                            $parts = parse_url($url);
                                            if (isset($parts['query'])) {
                                                parse_str($parts['query'], $query);
                                                $building_id = $query['building_id'];
                                            }

                                            // Create connection
                                            $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                            // Check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            $sql = "SELECT * FROM `apartments`,`apartment_type` WHERE `apartment_type`.`atype_id` = `apartments`.`atype_id` AND `apartments`.`bldid` = " . $building_id;
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td id="<?php echo $row['aid']; ?>"><?php echo $row['a_name']; ?></td>
                                                        <td><?php echo $row['atype_name']; ?></td>
                                                        <td id="size-<?php echo $row['aid']; ?>"><?php echo $row['a_size']; ?></td>
                                                        <td><input type="checkbox" <?php if($row['r_status'] == 1) echo 'checked' ?>></td>
                                                        <td>
                                                            <a class="btn btn-warning ams_btn_special" data-toggle="modal" data-target="#exampleModal" data-original-title="Edit" onclick="editApartment(<?php echo $row['aid']; ?>)"><i class="fa fa-pen"></i></a>
                                                            <a class="btn btn-danger ams_btn_special" onclick="deleteFloor(12);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash"></i></a>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Thêm mới phòng
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>

                    <div class="modal-body" id="addService">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Tên phòng</label>
                                <input id="name" type="text" name="name" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Chọn loại phòng</label>
                                <select id="selectType" class="custom-select">
                                    <?php
                                    // Create connection
                                    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM `apartment_type` WHERE `branch_id` = (SELECT `buildings`.`branch_id` FROM `buildings` WHERE `buildings`.`bldid` = $building_id)";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <option value="<?php echo $row['atype_id']; ?>"><?php echo $row['atype_name']; ?> (<?php echo $row['atype_style']; ?>)</option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="size">Diện tích (m<sup>2</sup>)</label>
                                <input id="size" type="number" name="size" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="modalButton" type="button" class="btn btn-success" onclick="apartment()">Thêm mới</button>
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
        let apartment_id = 0;

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

        function changeBuilding() {
            var selectBuilding = document.getElementById("selectBuilding");
            var text = selectBuilding.options[selectBuilding.selectedIndex].text;
            var value = selectBuilding.options[selectBuilding.selectedIndex].value;
            document.getElementById("buildingName").innerHTML = text;
            window.location.replace("<?php echo WEB_URL ?>pages/tables/apartments.php?building_id=" + value);
        }

        function editApartment(id) {
            document.getElementById("name").value = document.getElementById(id).innerHTML;
            document.getElementById("size").value = document.getElementById("size-" + id).innerHTML;
            document.getElementById("modalButton").innerHTML = "Thay đổi";
            apartment_id = id;
        }

        function addNewApartment() {
            document.getElementById("name").value = "";
            document.getElementById("size").value = "";
            document.getElementById("modalButton").innerHTML = "Thêm mới";
            apartment_id = 0;
        }

        function apartment(){
            $.ajax({
                url: "apartment.php",
                type: "POST",
                data: {
                    apartmentId: apartment_id,
                    buildingId: building_id,
                    apartmentName: document.getElementById("name").value,
                    apartmentSize: document.getElementById("size").value,
                    apartmentType: document.getElementById("selectType").value,
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