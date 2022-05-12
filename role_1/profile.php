<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Cá nhân</title>

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

        $result = mysqli_query($conn, "SELECT * FROM residents WHERE rsd_mail = '" . $_SESSION['email'] . "'");
        $data = mysqli_fetch_array($result);
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thông tin cá nhân</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Thông tin cá nhân</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div id="success-modal" class="alert alert-success d-none" role="alert">
                        Cập nhật thông tin thành công!
                    </div>
                    <div id="danger-modal" class="alert alert-danger d-none" role="alert">
                        Cập nhật thông tin không thành công!
                    </div>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin cá nhân</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input id="name" type="text" class="form-control" placeholder="Nhập tên" autocomplete="off" value="<?php echo $data['rsd_name'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="mail" type="text" class="form-control" readonly autocomplete="off" value="<?php echo $data['rsd_mail'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Số căn cước</label>
                                            <input id="identity" type="text" class="form-control" placeholder="Nhập số căn cước" autocomplete="off" value="<?php echo $data['rsd_identity'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input id="phone" type="text" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off" value="<?php echo $data['rsd_phone'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <input id="dob" type="date" class="form-control" autocomplete="off" value="<?php echo $data['rsd_dob'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Hình ảnh</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" style="cursor: pointer;" class="custom-file-input" ID="FileUpload" onchange="readURL(this)" />
                                                    <label class="custom-file-label" id="file-name">Chọn hình ảnh</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary" onclick="editProfile()">Lưu thông tin</button>
                                    </div>
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
                                    <img id="edit-image" src="<?php echo WEB_URL ?>dist/img/tennants/<?php echo $data['rsd_image'] ?>" Width="100%" Height="100%" />
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
    <script type="text/javascript">
        var fileNameEdited = '<?php echo $data['rsd_image']; ?>';
        var fileEdited = null;

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                fileNameEdited = input.files[0].name;
                fileEdited = input.files[0];

                reader.onload = function(e) {
                    $('#edit-image').attr('src', e.target.result);
                };

                document.getElementById("file-name").innerHTML = input.files[0].name;

                reader.readAsDataURL(input.files[0]);
            }
        }

        function editProfile() {

            $.ajax({
                url: "edit_profile.php",
                type: "POST",
                data: {
                    name: document.getElementById('name').value,
                    phone: document.getElementById('phone').value,
                    identity: document.getElementById('identity').value,
                    dob: document.getElementById('dob').value,
                    image: fileNameEdited
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        console.log("data edit successfully");
                        document.getElementById("success-modal").classList.remove("d-none");
                        document.getElementById("danger-modal").classList.add("d-none");

                        setTimeout(function() {
                            document.getElementById("success-modal").classList.add("d-none");
                        }, 5000);
                    } else {
                        console.log("data not added successfully");
                        document.getElementById("danger-modal").classList.remove("d-none");
                        document.getElementById("success-modal").classList.add("d-none");

                        setTimeout(function() {
                            document.getElementById("danger-modal").classList.add("d-none");
                        }, 5000);
                    }
                }
            });

            if (fileEdited != null) {
                //Post image to server
                var form = new FormData();
                form.append("image", fileEdited);

                $.ajax({
                    type: "POST",
                    url: "upload_profile_image.php",
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
        }
    </script>
</body>

</html>