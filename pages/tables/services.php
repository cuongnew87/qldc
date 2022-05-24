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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <!--Card image-->
                                    <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Danh sách các dịch vụ</h3>

                                        <div>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="addNewService()">Thêm mới dịch vụ</button>
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
                                                <th>Tên dịch vụ</th>
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

                                            $sql = "SELECT * FROM `utilities`";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td id="<?php echo $row['utltid']; ?>"><?php echo $row['utlt_name']; ?></td>
                                                        <td>
                                                            <a class="btn btn-warning ams_btn_special" id="edit" data-toggle="modal" data-target="#exampleModal" data-original-title="Edit" onclick="editService(<?php echo $row['utltid']; ?>)"><i class="fa fa-pen"></i></a>
                                                            <a class="btn btn-danger ams_btn_special" data-original-title="Delete" onclick="deleteService(<?php echo $row['utltid'] ?>)"><i class="fa fa-trash"></i></a>
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
                            Thêm mới dịch vụ
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
                                <label for="name">Tên dịch vụ</label>
                                <input id="name" type="text" name="name" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="modalButton" type="button" class="btn btn-success" onclick="service()">Thêm mới</button>
                        </div>
                    </div>

                    <hr style="width: 100%; background-color: black;" />
                    <h4 style="text-align:center">Thêm bằng file exel</h4>
                    <div class="modal-body" id="addServiceExel">
                        <div class="modal-body">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" style="cursor: pointer;" class="custom-file-input" ID="fileUpload" onclick="UploadProcess()" />
                                    <label class="custom-file-label" id="file-name">Chọn file exel để nhập</label>
                                </div>
                                <input type="button" id="upload" value="Upload" onclick="UploadProcess()" />
                            </div>
                            <div id="ExcelTable"></div>
                        </div>
                        <div class="modal-footer">
                            <button id="modalButton" type="button" class="btn btn-success" onclick="service()">Thêm mới hàng loạt</button>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script type="text/javascript">
    function UploadProcess() {
        //Reference the FileUpload element.
        var fileUpload = document.getElementById("fileUpload");
 
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        GetTableFromExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        GetTableFromExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
    };
    function GetTableFromExcel(data) {
        //Read the Excel File data in binary
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
 
        //get the name of First Sheet.
        var Sheet = workbook.SheetNames[0];
 
        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);
 
        //Create a HTML Table element.
        var myTable  = document.createElement("table");
        myTable.border = "1";
 
        //Add the header row.
        var row = myTable.insertRow(-1);
 
        //Add the header cells.
        var headerCell = document.createElement("TH");
        headerCell.innerHTML = "STT";
        row.appendChild(headerCell);
 
        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Name";
        row.appendChild(headerCell);
 
 
        //Add the data rows from Excel file.
        for (var i = 0; i < excelRows.length; i++) {
            //Add the data row.
            var row = myTable.insertRow(-1);
 
            //Add the data cells.
            var cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].STT;
 
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Name;

            $.ajax({
                url: "service.php",
                type: "POST",
                data: {
                    serviceId: 0,
                    serviceName: excelRows[i].Name,
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
        
 
        var ExcelTable = document.getElementById("ExcelTable");
        ExcelTable.innerHTML = "";
        ExcelTable.appendChild(myTable);
    };
</script>
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

        function deleteService() {
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
    <script>
        function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            // var dataType = 'application/vnd.ms-excel;charset=utf-8';
            var dataType = "text/xls;charset=utf-8,%EF%BB%BF" + encodeURI(dataType);
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
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