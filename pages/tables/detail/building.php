<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Chi tiết tòa nhà</title>

    <?php
    include('../../../components/header_scripts.php');
    ?>
</head>

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

$result = mysqli_query($conn, "SELECT * FROM buildings, owners where buildings.ownid = owners.ownid and bldid = " . $building_id);
$data = mysqli_fetch_array($result);
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        include('../../../components/navbar.php');
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        include('../../../components/main_sidebar_container.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thông tin chi tiết tòa nhà</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Thông tin chi tiết tòa nhà</li>
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
                                    <h3 class="card-title">Thông tin tòa nhà</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Tên tòa nhà</label>
                                            <input id="buildingName" type="text" class="form-control" placeholder="Nhập tên" autocomplete="off" value="<?php echo $data['bld_name'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Chủ sở hữu</label>
                                            <select class="custom-select" id="ownerSelect">
                                                <?php
                                                $sql = "SELECT * FROM owners";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <option value="<?php echo $row['ownid']; ?>" <?php if ($row['ownid'] == $data['ownid']) echo "selected"; ?>><?php echo $row['o_name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input id="buildingAddress" type="text" class="form-control" placeholder="Nhập địa chỉ" autocomplete="off" value="<?php echo $data['bld_address'] ?>" />
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
                                        <button type="button" class="btn btn-primary" onclick="editBuilding(<?php echo $building_id; ?>)">Lưu thông tin</button>
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
                                    <img id="edit-image" src="<?php echo WEB_URL ?>dist/img/buildings/<?php echo $data['bld_image'] ?>" Width="100%" Height="100%" />
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php
        include('../../../components/footer.php');
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
    include('../../../components/footer_scripts.php');
    ?>
    <script type="text/javascript">
        var fileNameEdited = '<?php echo $data['bld_image']; ?>';
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

        function editBuilding(id) {

            $.ajax({
                url: "edit_building.php",
                type: "POST",
                data: {
                    buildingId: id,
                    buildingName: document.getElementById("buildingName").value,
                    buildingAddress: document.getElementById("buildingAddress").value,
                    ownerSelect: document.getElementById("ownerSelect").value,
                    buildingImage: fileNameEdited,
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

            if(fileEdited != null){
                //Post image to server
                var form = new FormData();
                form.append("image", fileEdited);

                $.ajax({
                    type: "POST",
                    url: "upload_building_image.php",
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