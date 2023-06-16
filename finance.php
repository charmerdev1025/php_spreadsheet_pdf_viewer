<?php
  session_start();
  include 'config.php';
  $finances_query = "select * from finances";
  $finances = $conn->query($finances_query);

?>
<!DOCTYPE html>
<html>

<head>
  <title>Search PDF into Google Spreadsheet api</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.1" rel="stylesheet" />

  <!--------- Dropzone JS and CSS file --------->
  <!-- <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="assets/custom.css">
  <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-danger position-absolute w-100"></div>
  <!-- navbar -->
  <aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main" data-color="danger">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0"
        href=" https://demos.creative-tim.com/argon-dashboard-pro/pages/dashboards/default.html " target="_blank">
        <img src="assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">DG finder</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="home.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-search text-lg text-info"></i>
            </div>
            <span class="nav-link-text ms-1">Manifest Search</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-user text-success text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">User</span>
          </a>
        </li>
        <?php
          if($_SESSION["role"] == "2") {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="subscriber.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-archive-2 text-success text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">Subscriber</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="finance.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-dollar text-warning text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">Finance</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sector.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-bank text-warning text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">Sector</span>
          </a>
        </li>        
        <?php
          }
        ?>        
        <li class="nav-item">
          <a class="nav-link" href="compatibility.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-retweet text-warning text-lg"></i>
            </div>
            <span class="nav-link-text ms-1">Compatibility</span>
          </a>
        </li>
      <?php
        if(isset($_SESSION["email"])) {
      ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-button-power text-danger text-sm"></i>
            </div>
            <span class="nav-link-text ms-1">Log Out</span>
          </a>
        </li>
      <?php
        }
      ?>
      </ul>
    </div>
  </aside>
  <!-- load content from other views -->
  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg  px-0 mx-4 shadow-none border-radius-xl z-index-sticky "
      id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="text-white" href="javascript:;">
                <i class="ni ni-box-2"></i>
              </a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Users</li>
          </ol>
        </nav>
        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          <a href="javascript:;" class="nav-link p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <ul class="navbar-nav justify-content-end">
            <?php
            if(!isset($_SESSION["email"])) {
          ?>
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:void(0);" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign In</span>
              </a>
            </li>
            <?php
            } else {
            ?>
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:void(0);" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?php echo $_SESSION["email"];?></span>
              </a>
            </li>
            <?php
            }
          ?>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Finance List</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Code</th>
                    <th>Company</th>
                    <th>Sector</th>
                    <th>Price</th>
                    <th>1 day</th>
                    <!-- <th>3 day</th> -->
                    <th>1 week</th>
                    <!-- <th>2 week</th> -->
                    <th>1 month</th>
                    <!-- <th>3 month</th> -->
                    <th>6 month</th>
                    <th>1 year</th>
                    <th>Volume</th>
                    <th>Market Cap</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
            $no = 0;
            while($finance = $finances->fetch_assoc()) {
              $no++;
            ?>
                <tr>
                  <!-- <td class="text-sm font-weight-normal"><?= $no ?></td> -->
                  <td class="text-sm font-weight-normal"><?= $finance["code"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["company"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["sector"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["price"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["one_day"] ?></td>
                  <!-- <td class="text-sm font-weight-normal"><?= $finance["three_day"] ?></td> -->
                  <td class="text-sm font-weight-normal"><?= $finance["one_week"] ?></td>
                  <!-- <td class="text-sm font-weight-normal"><?= $finance["two_week"] ?></td> -->
                  <td class="text-sm font-weight-normal"><?= $finance["one_month"] ?></td>
                  <!-- <td class="text-sm font-weight-normal"><?= $finance["three_month"] ?></td> -->
                  <td class="text-sm font-weight-normal"><?= $finance["six_month"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["one_year"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["volume"] ?></td>
                  <td class="text-sm font-weight-normal"><?= $finance["mkt_cap"] ?></td>
                </tr>
            <?php
            }
            ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                Copyright © 2022 - Manifest Search
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About
                    Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                    target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 bg-transparent ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">DGfinder Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary"
              onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
            onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
            onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark mb-1">
        <div class="d-flex my-4">
          <h6 class="mb-0">Sidenav Mini</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarMinimize"
              onclick="navbarMinimize(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/jquery.min.js"></script>
  <!-- <script src="assets/bootstrap.min.js"></script> -->
  <!----------- Custom JS --------------->
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="assets/js/plugins/jkanban/jkanban.js"></script>
  <script src="assets/js/plugins/datatables.js"></script>
  <script>
    const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
      searchable: true,
      fixedHeight: true
    });

  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/argon-dashboard.js?v=2.0.1"></script>
  <!-- <script src="assets/js/custom.js"></script> -->
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>