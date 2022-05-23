<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Chi phí</title>

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
                            <h1>Danh sách hóa đơn</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Bảng</li>
                                <li class="breadcrumb-item active">Danh sách hóa đơn</li>
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

                                    <h3 class="card-title">Danh sách hóa đơn</h3>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Thêm mới hóa đơn</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên tòa nhà</th>
                                                <th>Phòng</th>
                                                <th>Tổng tiền</th>
                                                <th>Ngày trả tiền</th>
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

                                            $sql = "SELECT * FROM bills, contracts, apartments, buildings WHERE bills.aid = apartments.aid AND contracts.aid = apartments.aid AND apartments.bldid = buildings.bldid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $index;
                                                            $index++; ?></td>
                                                        <td><?php echo $row['bld_name']; ?></td>
                                                        <td><?php echo $row['a_name']; ?></td>
                                                        <td><?php echo $row['total']; ?></td>
                                                        <td><?php echo $row['bill_paydate']; ?></td>
                                                        <td>
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

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Thêm mới hóa đơn
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
                                <label for="apartment">Chọn phòng</label>
                                <select name="apartment" id="selectApartment" class="custom-select">
                                    <?php
                                    // Create connection
                                    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM apartments, buildings WHERE apartments.bldid = buildings.bldid AND r_status = 1";
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
                                <label for="date">Ngày trả</label>
                                <input id="date" type="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Ngày trả</label>
                                <input id="date" type="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>File exel</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" style="cursor: pointer;" class="custom-file-input" ID="fileUpload" />
                                        <label class="custom-file-label" id="file-name">Chọn file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="addNewBill()">Thêm mới</button>
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

        function addNewBill() {

            //Reference the FileUpload element.
            var fileUpload = document.getElementById("fileUpload");

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function(e) {
                            GetTableFromExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function(e) {
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

            // $.ajax({
            //     url: "add_rentals.php",
            //     type: "POST",
            //     data: {
            //         rentalApartment: document.getElementById("selectApartment").value,
            //         rentalDate: document.getElementById("date").value,
            //     },
            //     success: function(dataResult) {
            //         var result = JSON.parse(dataResult);

            //         if (result.statusCode == 200) {
            //             location.reload();
            //             console.log("data edit successfully");
            //         } else {
            //             console.log("data not added successfully");
            //             console.log(result);
            //         }
            //     }
            // });
        }

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
        headerCell.innerHTML = "Id";
        row.appendChild(headerCell);
 
        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Name";
        row.appendChild(headerCell);
 
        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Country";
        row.appendChild(headerCell);
        
        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Age";
        row.appendChild(headerCell);
        
        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Date";
        row.appendChild(headerCell);
         
         headerCell = document.createElement("TH");
        headerCell.innerHTML = "Gender";
        row.appendChild(headerCell);
 
 
        //Add the data rows from Excel file.
        for (var i = 0; i < excelRows.length; i++) {
            //Add the data row.
            var row = myTable.insertRow(-1);
 
            //Add the data cells.
            var cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Id;
 
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Name;
 
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Country;
            
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Age;
            
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Date;
            
            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[i].Gender;
        }
        
 
        var ExcelTable = document.getElementById("ExcelTable");
        ExcelTable.innerHTML = "";
        ExcelTable.appendChild(myTable);
    };
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
</body>

</html>