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
                <li class="breadcrumb-item active">User Profile</li>
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
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
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
                      WHERE `residents`.`aid` = (SELECT `residents`.`aid` FROM `residents` WHERE `residents`.`rsdid` = 1) 
                      AND `residents`.`rsdid` <> " . $tennant_id;
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
                              Lorem ipsum represents a long-held tradition for designers,
                              typographers and the like. Some people hate it and argue for
                              its demise, but others ignore the hate as they create awesome
                              tools to help create filler text for everyone from bacon lovers
                              to Charlie Sheen fans.
                            </p>

                          </div>
                          <!-- /.post -->
                      <?php
                        }
                      }
                      ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                      <!-- The timeline -->
                      <div class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <div class="time-label">
                          <span class="bg-danger">
                            10 Feb. 2014
                          </span>
                        </div>
                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                          <i class="fas fa-envelope bg-primary"></i>

                          <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> 12:05</span>

                            <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                            <div class="timeline-body">
                              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                              weebly ning heekya handango imeem plugg dopplr jibjab, movity
                              jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                              quora plaxo ideeli hulu weebly balihoo...
                            </div>
                            <div class="timeline-footer">
                              <a href="#" class="btn btn-primary btn-sm">Read more</a>
                              <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                          <i class="fas fa-user bg-info"></i>

                          <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                            <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                            </h3>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                          <i class="fas fa-comments bg-warning"></i>

                          <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                            <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                            <div class="timeline-body">
                              Take me to your leader!
                              Switzerland is small and neutral!
                              We are more like Germany, ambitious and misunderstood!
                            </div>
                            <div class="timeline-footer">
                              <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline time label -->
                        <div class="time-label">
                          <span class="bg-success">
                            3 Jan. 2014
                          </span>
                        </div>
                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                          <i class="fas fa-camera bg-purple"></i>

                          <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                            <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                            <div class="timeline-body">
                              <img src="https://placehold.it/150x100" alt="...">
                              <img src="https://placehold.it/150x100" alt="...">
                              <img src="https://placehold.it/150x100" alt="...">
                              <img src="https://placehold.it/150x100" alt="...">
                            </div>
                          </div>
                        </div>
                        <!-- END timeline item -->
                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Họ và tên</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" placeholder="Họ và tên" value="<?php echo $data['rsd_name']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="<?php echo $data['rsd_mail']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Số điện thoại</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName2" placeholder="Số điện thoại" value="<?php echo $data['rsd_phone']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">Giới tính</label>
                          <div class="col-sm-10 d-flex">
                            <div class="form-check m-1">
                              <input class="form-check-input" type="radio" name="gender" checked>
                              <label class="form-check-label">Nam</label>
                            </div>
                            <div class="form-check m-1">
                              <input class="form-check-input" type="radio" name="gender">
                              <label class="form-check-label">Nữ</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputSkills" class="col-sm-2 col-form-label">Số căn cước</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSkills" placeholder="Số căn cước" value="<?php echo $data['rsd_identity']; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Cập nhật thông tin</button>
                          </div>
                        </div>
                      </form>
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
  </script>
</body>

</html>