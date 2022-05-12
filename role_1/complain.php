<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Thêm khiếu nại</title>

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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thêm mới khiếu nại</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Thêm khiếu nại</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <?php
            // Create connection
            $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = mysqli_query($conn, "SELECT * FROM residents, apartments where residents.aid = apartments.aid and rsd_mail = '" . $_SESSION['email'] . "'");
            $data = mysqli_fetch_array($result);
            ?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <input id="subject" class="form-control" placeholder="Chủ đề:">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="compose-textarea" class="form-control" style="height: 300px"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="button" class="btn btn-primary" onclick="sendComplain()"><i class="far fa-envelope"></i> Send</button>
                                    </div>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
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
        function sendComplain() {
            $.ajax({
                url: "send_complain.php",
                type: "POST",
                data: {
                    apartmentId: <?php echo $data['aid'] ?>,
                    subject: document.getElementById("subject").value,
                    content: document.getElementById("compose-textarea").value,
                },
                success: function(dataResult) {
                    var result = JSON.parse(dataResult);

                    if (result.statusCode == 200) {
                        location.reload();
                        console.log("data edit successfully");
                    } else {
                        console.log("data not added successfully");
                    }
                }
            });
        }
    </script>
</body>

</html>