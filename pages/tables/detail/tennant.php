<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Chi tiết cư dân</title>

  <?php
  include('../../../components/header_scripts.php');
  ?>
  <style type="text/css">
    .rounded-circle {
      border-radius: 50%;
      min-width: 100%;
    }
  </style>
</head>

<?php
$tennant_id = 1;
$index = 1;
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];
$parts = parse_url($url);
if (isset($parts['query'])) {
  parse_str($parts['query'], $query);
  $tennant_id = $query['tennant_id'];
}

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn, "SELECT * FROM `residents`,`buildings` WHERE `residents`.`bldid` = `buildings`.`bldid` AND `residents`.`rsdid` =" . $tennant_id);
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
              <h1>Thông tin chi tiết</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Hồ sơ cá nhân</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <input type="hidden" id="buildingId" value="<?php echo $data['bldid'] ?>">
                  <input type="hidden" id="apartmentId" value="<?php echo $data['aid'] ?>">
                  <div class="text-center">
                    <img class="img-fluid rounded-circle" src="<?php echo WEB_URL ?>dist/img/tennants/<?php echo $data['rsd_image']; ?>" alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center"><?php echo $data['rsd_name']; ?></h3>

                  <p class="text-muted text-center"><?php echo $data['rsd_relationship']; ?></p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Mã căn cước</b> <a class="float-right"><?php echo $data['rsd_identity']; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Ngày sinh</b> <a class="float-right"><?php echo $data['rsd_dob']; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Giới tính</b> <a class="float-right"><?php echo $data['rsd_sex']; ?></a>
                    </li>
                  </ul>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Thông tin</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <strong><i class="fas fa-envelope mr-1"></i> Địa chỉ mail</strong>

                  <p class="text-muted"><?php echo $data['rsd_mail']; ?></p>

                  <hr>

                  <strong><i class="fas fa-phone-alt mr-1"></i> Liên hệ</strong>

                  <p class="text-muted"><?php echo $data['rsd_phone']; ?></p>

                  <hr>

                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ hiện tại</strong>

                  <p class="text-muted">
                    <?php echo $data['bld_name']; ?>, <?php echo $data['bld_address']; ?>
                  </p>

                  <hr>

                  <strong><i class="far fa-building mr-1"></i> Căn hộ</strong>

                  <p class="text-muted"><?php echo $data['bld_name']; ?></p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Thành viên trong gia đình</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Cài đặt</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <?php
                      $tennant_id = 1;
                      $index = 1;
                      $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
                      $url = $base_url . $_SERVER["REQUEST_URI"];
                      $parts = parse_url($url);
                      if (isset($parts['query'])) {
                        parse_str($parts['query'], $query);
                        $tennant_id = $query['tennant_id'];
                      }

                      // Create connection
                      $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                      // Check connection
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }

                      $sql = "SELECT * FROM `residents` 
                      WHERE `residents`.`aid` = (SELECT `residents`.`aid` FROM `residents` WHERE `residents`.`rsdid` = $tennant_id) 
                      AND `residents`.`rsdid` <> " . $tennant_id . " AND `residents`.`rsd_relationship` <> 'Không'";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <!-- Post -->
                          <div class="post">
                            <div class="user-block">
                              <img class="img-circle img-bordered-sm" src="<?php echo WEB_URL ?>dist/img/tennants/<?php echo $row['rsd_image'] ?>" alt="user image">
                              <span class="username">
                                <a href="<?php echo WEB_URL ?>pages/tables/detail/tennant.php?tennant_id=<?php echo $row['rsdid']; ?>"><?php echo $row['rsd_name']; ?></a>
                              </span>
                              <span class="description"><?php echo $row['rsd_relationship']; ?></span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                              None
                            </p>

                          </div>
                          <!-- /.post -->
                      <?php
                        }
                      }
                      ?>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Thêm mới thành viên</button>
                    </div>

                    <div class="tab-pane" id="settings">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="Họ và tên" value="<?php echo $data['rsd_name']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $data['rsd_mail']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" placeholder="Số điện thoại" value="<?php echo $data['rsd_phone']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">Giới tính</label>
                          <div class="col-sm-10 d-flex">
                            <div class="form-check m-1">
                              <input class="form-check-input" type="radio" name="gender" value="Nam" <?php if ($data['rsd_sex'] == "Nam") echo "checked" ?>>
                              <label class="form-check-label">Nam</label>
                            </div>
                            <div class="form-check m-1">
                              <input class="form-check-input" type="radio" name="gender" value="Nữ" <?php if ($data['rsd_sex'] == "Nữ") echo "checked" ?>>
                              <label class="form-check-label">Nữ</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="identity" class="col-sm-2 col-form-label">Số căn cước</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="identity" placeholder="Số căn cước" value="<?php echo $data['rsd_identity']; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="button" class="btn btn-danger" onclick="updateInfo(<?php echo $tennant_id ?>)">Cập nhật thông tin</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
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
                <label for="member">Chọn thành viên</label>
                <select name="member" id="selectMember" class="custom-select">
                  <?php
                  // Create connection
                  $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                  // Check connection
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }

                  $sql = "SELECT * FROM residents WHERE rsd_relationship = 'Không' AND rsdid <> $tennant_id";
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
                <label for="relationship">Quan hệ với chủ hộ</label>
                <input id="relationship" type="text" name="relationship" class="form-control" required autocomplete="off">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="addNewMember()">Thêm mới</button>
            </div>
          </div>
        </div>
      </div>
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

    function updateInfo(id) {
      let gender = "Nam";
      var radios = document.getElementsByName('gender');
      for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
          // do whatever you want with the checked radio
          gender = radios[i].value;

          // only one radio can be logically checked, don't check the rest
          break;
        }
      }

      $.ajax({
        url: "edit_tennant.php",
        type: "POST",
        data: {
          tennantId: id,
          tennantName: document.getElementById("name").value,
          tennantEmail: document.getElementById("email").value,
          tennantIdentity: document.getElementById("identity").value,
          tennantPhone: document.getElementById("phone").value,
          tennantGender: gender,
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

    function addNewMember() {
      $.ajax({
        url: "add_member.php",
        type: "POST",
        data: {
          memberId: document.getElementById('selectMember').value,
          memberRelationship: document.getElementById("relationship").value,
          buildingId: document.getElementById("buildingId").value,
          apartmentId: document.getElementById("apartmentId").value
        },
        success: function(dataResult) {
          var result = JSON.parse(dataResult);

          if (result.statusCode == 200) {
            console.log("data edit successfully");
            location.reload();
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