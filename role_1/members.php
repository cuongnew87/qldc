<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách thành viên</title>

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
                            <h1>Danh sách thành viên</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách thành viên</li>
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
                                                <th>Tên thành viên</th>
                                                <th>Quan hệ với chủ hộ</th>
                                                <th>Số điện thoại</th>
                                                <th>Ngày sinh</th>
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

                                            $sql = "SELECT * FROM residents WHERE aid = (SELECT aid FROM residents WHERE rsd_mail = '" . $_SESSION['email'] . "')";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td id="name<?php echo $row['rsdid'] ?>"><?php echo $row['rsd_name']; ?></td>
                                                        <td id="relationship<?php echo $row['rsdid'] ?>"><?php echo $row['rsd_relationship']; ?></td>
                                                        <td id="phone<?php echo $row['rsdid'] ?>"><?php echo $row['rsd_phone']; ?></td>
                                                        <td id="dob<?php echo $row['rsdid'] ?>"><?php echo $row['rsd_dob']; ?></td>
                                                        <input type="hidden" id="identity<?php echo $row['rsdid'] ?>" value="<?php echo $row['rsd_identity']; ?>">
                                                        <input type="hidden" id="mail<?php echo $row['rsdid'] ?>" value="<?php echo $row['rsd_mail']; ?>">
                                                        <input type="hidden" id="gender<?php echo $row['rsdid'] ?>" value="<?php echo $row['rsd_sex']; ?>">
                                                        <input type="hidden" id="image<?php echo $row['rsdid'] ?>" value="<?php echo $row['rsd_image']; ?>">
                                                        <td>
                                                            <a class="btn btn-success ams_btn_special" data-toggle="modal" data-target="#exampleModal" onclick="displayDetail(<?php echo $row['rsdid'] ?>)">
                                                                <i class="fa fa-eye"></i></a>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title" id="myModalLabel">Thông tin chi tiết</h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <img id="detailImage" src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRbezqZpEuwGSvitKy3wrwnth5kysKdRqBW54cAszm_wiutku3R" name="aboutme" width="140" height="140" border="0" class="img-circle"></a>
                            <h3 id="detailName" class="media-heading"></h3>
                            <span><strong>Quan hệ với chủ hộ: </strong></span>
                            <span class="label label-warning" id="detailRelationship"></span>
                        </center>
                        <hr>
                        <center>
                            <p class="text-left" id="detailIdentity"><strong>Sô căn cước: </strong></p>
                            <p class="text-left" id="detailPhone"><strong>Sô điện thoại: </strong></p>
                            <p class="text-left" id="detailMail"><strong>Email: </strong></p>
                            <p class="text-left" id="detailGender"><strong>Giới tính: </strong></p>
                            <p class="text-left" id="detailDob"><strong>Ngày sinh: </strong></p>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>

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
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

        function displayDetail(id) {
            document.getElementById("detailName").innerHTML = document.getElementById("name" + id).innerHTML;
            document.getElementById("detailImage").src = "../dist/img/tennants/" + document.getElementById("image" + id).value;
            document.getElementById("detailRelationship").innerHTML = document.getElementById("relationship" + id).innerHTML;
            document.getElementById("detailIdentity").innerHTML =  "Số căn cước: " + document.getElementById("identity" + id).value;
            document.getElementById("detailPhone").innerHTML =  "Số điện thoại: " + document.getElementById("phone" + id).innerHTML;
            document.getElementById("detailMail").innerHTML =  "Email: " + document.getElementById("mail" + id).value;
            document.getElementById("detailGender").innerHTML =  "Giới tính: " + document.getElementById("gender" + id).value;
            document.getElementById("detailDob").innerHTML =  "Ngày sinh: " + document.getElementById("dob" + id).innerHTML;
        }
    </script>
</body>

</html>