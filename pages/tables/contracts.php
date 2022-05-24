<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách hợp đồng</title>

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
                            <h1>Danh sách hợp đồng</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách hợp đồng</li>
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

                                    <h3 class="card-title">Danh sách hợp đồng</h3>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Thêm mới hợp đồng</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên hợp đồng</th>
                                                <th>Người thuê</th>
                                                <th>Loại hợp đồng</th>
                                                <th>Ngày ký hợp đồng</th>
                                                <th>Tiền thuê theo tháng</th>
                                                <th>Tiền mua</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            $sql = "SELECT * FROM contracts, residents WHERE residents.rsdid = contracts.rsdid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td><?php echo $row['ctr_name']; ?></td>
                                                        <td><?php echo $row['rsd_name']; ?></td>
                                                        <td><?php echo $row['ctr_type']; ?></td>
                                                        <td><?php echo $row['ctr_date']; ?></td>
                                                        <td><?php echo $row['rent_fee']; ?></td>
                                                        <td><?php echo $row['buy_fee']; ?></td>
                                                        <td>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Thêm mới tòa nhà
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
                                <label for="name">Tên hợp đồng</label>
                                <input id="name" type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Loại hợp đồng</label>
                                <input id="type" type="text" name="type" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Ngày tạo</label>
                                <input id="date" type="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="apartment">Chọn người thuê/mua</label>
                                <select name="apartment" id="selectResident" class="custom-select">
                                    <?php
                                    // Create connection
                                    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM residents";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <option value="<?php echo $row['rsdid'] ?>"><?php echo $row['rsd_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
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

                                    $sql = "SELECT * FROM apartments, buildings WHERE apartments.bldid = buildings.bldid AND r_status = 0";
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
                                <label for="rent">Tiền thuê theo tháng</label>
                                <input id="rent" type="number" name="rent" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="buy">Tiền mua nhà</label>
                                <input id="buy" type="number" name="buy" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>File hợp đồng</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" style="cursor: pointer;" class="custom-file-input" ID="FileUpload" onchange="readURL(this)" />
                                        <label class="custom-file-label" id="file-name">Chọn file hợp đồng</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-success" onclick="addNewContract()">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>
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

        var fileName = 'contract-default.pdf';
        var file = null;

        function changeBranch() {
            var selectBranch = document.getElementById("selectBranch");
            var text = selectBranch.options[selectBranch.selectedIndex].text;
            var value = selectBranch.options[selectBranch.selectedIndex].value;
            document.getElementById("branchName").innerHTML = text;
            window.location.replace("<?php echo WEB_URL ?>pages/tables/buildings.php?branch_id=" + value);
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                fileName = input.files[0].name;
                file = input.files[0];

                document.getElementById("file-name").innerHTML = input.files[0].name;
            }
        }

        function addNewContract() {

            $.ajax({
                url: "add_contract.php",
                type: "POST",
                data: {
                    contractName: document.getElementById("name").value,
                    contractType: document.getElementById("type").value,
                    contractDate: document.getElementById("date").value,
                    apartmentId: document.getElementById("selectApartment").value,
                    residentId: document.getElementById("selectResident").value,
                    contractRent: document.getElementById("rent").value,
                    contractBuy: document.getElementById("buy").value,
                    contractFile: fileName
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        console.log("data edit successfully");
                    } else {
                        console.log("data not added successfully");
                        console.log(result);
                    }
                }
            });

            if (file != null) {
                //Post image to server
                var form = new FormData();
                form.append("image", file);

                $.ajax({
                    type: "POST",
                    url: "upload_contract_file.php",
                    processData: false,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    data: form,
                    success: function(response) {
                        let result = JSON.parse(response);
                        console.log(result);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }

            file = null;
            fileName = null;
            location.reload();
        }
    </script>
</body>

</html>