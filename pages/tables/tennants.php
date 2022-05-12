<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách dân cư</title>

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
                            <h1>Danh sách dân cư</h1>
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
                                    <!--Card image-->
                                    <div
                                        class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Danh sách cư dân thuộc <span id="branchName"><span></h3>

                                        <div>
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#exampleModal">Thêm mới cư dân</button>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên người dân</th>
                                                <th>Thuộc căn hộ</th>
                                                <th>Số điện thoại</th>
                                                <th>Ngày sinh</th>
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

                                            $sql = "SELECT * FROM `residents`, `buildings`, `branches`
                                            WHERE `residents`.`bldid` = `buildings`.`bldid`
                                            AND `branches`.`branch_id` = `buildings`.`branch_id`
                                            AND `branches`.`branch_id` = " . $branch_id;
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $index;
                                                            $index++; ?></td>
                                                <td><?php echo $row['rsd_name']; ?></td>
                                                <td><?php echo $row['bld_name']; ?></td>
                                                <td><?php echo $row['rsd_phone']; ?></td>
                                                <td><?php echo $row['rsd_dob']; ?></td>
                                                <td>
                                                    <a class="btn btn-success ams_btn_special" data-toggle="tooltip"
                                                        href="<?php echo WEB_URL ?>pages/tables/detail/tennant.php?tennant_id=<?php echo $row['rsdid']; ?>">
                                                        <i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-danger ams_btn_special" data-toggle="tooltip"
                                                        onclick="deleteFloor(12);" href="javascript:;"
                                                        data-original-title="Delete">
                                                        <i class="fa fa-trash"></i></a>
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
                            Thêm mới dân cư
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
                                <label for="name">Họ và tên</label>
                                <input id="name" type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input id="phone" type="phone" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <div class="col-sm-10 d-flex">
                                    <div class="form-check m-1">
                                        <input class="form-check-input" value="Nam" type="radio" name="gender" checked>
                                        <label class="form-check-label">Nam</label>
                                    </div>
                                    <div class="form-check m-1">
                                        <input class="form-check-input" value="Nữ" type="radio" name="gender">
                                        <label class="form-check-label">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="identity">Số căn cước công dân</label>
                                <input id="identity" type="text" name="identity" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Ngày sinh</label>
                                <input id="dob" type="date" name="dob" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh (ảnh 128 x 128 px)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" style="cursor: pointer;" class="custom-file-input"
                                            ID="FileUpload" onchange="readURL(this)" />
                                        <label class="custom-file-label" id="file-name">Chọn hình ảnh</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-success" onclick="addNewTennant()">Thêm mới</button>
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

    function changeBranch() {
        var selectBranch = document.getElementById("selectBranch");
        var text = selectBranch.options[selectBranch.selectedIndex].text;
        var value = selectBranch.options[selectBranch.selectedIndex].value;
        document.getElementById("branchName").innerHTML = text;
        window.location.replace("<?php echo WEB_URL ?>pages/tables/tennants.php?branch_id=" + value);
    }

    var fileName = 'user-default.png';
    var file = null;

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            fileName = input.files[0].name;
            file = input.files[0];

            document.getElementById("file-name").innerHTML = input.files[0].name;
        }
    }

    function addNewTennant() {

        $.ajax({
            url: "add_tennant.php",
            type: "POST",
            data: {
                tennantName: document.getElementById("name").value,
                tennantEmail: document.getElementById("email").value,
                tennantPhone: document.getElementById("phone").value,
                tennantGender: document.querySelector('input[name="gender"]:checked').value,
                tennantPhone: document.getElementById("phone").value,
                tennantIdentity: document.getElementById("identity").value,
                tennantDob: document.getElementById("dob").value,
                tennantImage: fileName,
                tennantBuilding: document.getElementById("selectBranch").value,
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
            form.append("image", fileEdited);

            $.ajax({
                type: "POST",
                url: "upload_tennant_image.php",
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

        fileEdited = null;
        fileName = null;
        location.reload();
    }
    </script>
</body>

</html>