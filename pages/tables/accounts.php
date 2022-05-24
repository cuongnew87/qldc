<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Danh sách tài khoản</title>

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
                            <h1>Danh sách tài khoản</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách tài khoản</li>
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
                                <div class="card-header">
                                    <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Thêm mới tài khoản</button>
                                        </div>
                                        <div>
                                        <button class="btn btn-success" onclick="exportTableToExcel('example1')">Xuất file exel</button>
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
                                                <th>Tên tài khoản</th>
                                                <th>Mật khẩu</th>
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

                                            $sql = "SELECT * FROM user, residents WHERE user.user_id = residents.rsdid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td><?php echo $row['rsd_name']; ?></td>
                                                        <td><?php echo $row['user_mail']; ?></td>
                                                        <td><?php echo $row['user_pass']; ?></td>
                                                        <td>
                                                            <a class="btn btn-danger ams_btn_special" onclick="deleteAccount(<?php echo $row['id']; ?>);" data-original-title="Delete"><i class="fa fa-trash"></i></a>
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
                            Thêm mới tài khoản
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
                                <label for="name">Tên tài khoản</label>
                                <input id="name" type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input id="password" type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="residents">Chọn người dân</label>
                                <select name="residents" id="selectResident" class="custom-select">
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
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-success" onclick="addNewAccount()">Thêm mới</button>
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

        function addNewAccount() {

            $.ajax({
                url: "add_account.php",
                type: "POST",
                data: {
                    residentMail: document.getElementById("name").value,
                    residentName: document.getElementById("selectResident").innerHTML,
                    residentPassword: document.getElementById("password").value,
                    residentId: document.getElementById("selectResident").value,
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

            location.reload();
        }

        function deleteAccount(id){
            $.ajax({
                url: "delete_account.php",
                type: "POST",
                data: {
                    accountId: id,
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

            location.reload();
        }
    </script>
    <script>
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    // var dataType = 'application/vnd.ms-excel';
    var dataType = "text/xls;charset=utf-8,%EF%BB%BF" + encodeURI(dataType);
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
</body>

</html>