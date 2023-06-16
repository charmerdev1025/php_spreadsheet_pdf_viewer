<?php
  session_start();
  if(!isset($_SESSION["email"])) {
    header('Location:index.php');
    exit;
  }
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
  <!-- <link rel="stylesheet" href="assets/bootstrap.min.css"> -->

  <!--------- Dropzone JS and CSS file --------->
  <!-- <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="assets/dropzone.css">

  <link rel="stylesheet" href="assets/pdfjs-viewer.css">
  <link rel="stylesheet" href="assets/pdftoolbar.css">
  <link rel="stylesheet" href="assets/custom.css">
  <link rel="stylesheet" href="./pdfViewer/style.css" />
  <!-- <script src="assets/js/core/jquery.min.js" type="text/javascript"></script> -->
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
          <a class="nav-link active" href="home.php">
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
          <a class="nav-link" href="finance.php">
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Manifest Search</li>
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
          <ul class="navbar-nav  justify-content-end">
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
      <div class="row main-container">
        <div class="col-12">
          <div class="card">
            <div class="card-header p-3">
              <h5 class="mb-2">Manifest Search</h5>
              <p class="mb-0">Find dangerous goods in your manifest.</p>
            </div>
            <div class="card-body p-3">
              <div class="home-container">
                <div class="dropzone-container">
                  <form action="./upload.php" class="dropzone text-center"></form>
                  <section class="loading-container hidden">
                    <img src="assets/images/dgfinder_loader.svg">
                  </section>
                </div>
              </div>
              <div class="search-container row" style="display: none;">
                <div class="col-md-6 col-sm-12">
                  <div class="pdfView">
                    <div id="viewer"></div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="search-info">
                    <div class="file-info">
                      <p class="mb-0 search-filename">
                        <label>File name : </label> <span></span>
                      </p>
                      <p class="mb-0">
                        <label>Search pages : </label> <span id="searchPage"></span>
                      </p>
                      <p class="mb-0 search-count">
                        <label>Results : </label> <span id="countSearch">0</span><span> of </span><span
                          id="totalSearch">0</span>
                        <select name="searchWords" id="searchWords" style="width:200px;display: none;">
                        </select>
                      </p>
                      <p style="display: none">
                        <label>text : </label> <input id="searchString" type="text" disabled style="width:200px" />
                      </p>
                    </div>
                    <div class="search-result p-3 row">
                      <div class="search-title pb-3">Potential Results</div>
                      <table class="table table-bordered mb-0">
                        <thead>
                          <th>No</th>
                          <th>UN Number</th>
                          <th>Proper Shipping Name</th>
                          <th>Class</th>
                          <th>Hazard Label</th>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="result-manage mt-2">
                    <p>
                      <img src="assets/images/result.png" class="commonImage" />
                      <span>These results may require further investigation</span>
                    </p>
                    <div>
                      <div id="page-range" style="display: none">
                        <input id="from" class="pageRange" type="text" value="1" />
                        <span> ~ </span>
                        <input id="to" class="pageRange" type="text" value="1" />
                      </div>
                    </div>
                    <div class="result-btns text-center row">
                      <div class="col-md-6">
                        <button class="btn prev buttonCtl" alt="-1">Previous</button>
                      </div>
                      <div class="col-md-6">
                        <button class="btn next buttonCtl" alt="1">Next</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3  ">
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
  <input type="hidden" class="filename" />
  <script src="assets/jquery.min.js"></script>
  <script src="assets/pdf.min.js"></script>
  <script src="assets/pdfjs-viewer.js"></script>
  <script src="assets/popper.min.js"></script>
  <!-- <script src="assets/bootstrap.min.js"></script> -->
  <!----------- Custom JS --------------->
  <script src="assets/dropzone.js"></script>
  <script src="./lib/webviewer.min.js"></script>
  <script src="./pdfViewer/old-browser-checker.js"></script>
  <script src="./pdfViewer/global.js"></script>
  <script src="./pdfViewer/modernizr.custom.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="assets/js/plugins/jkanban/jkanban.js"></script>

  <script>
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
  <script>
    let PDFFILE = "";
    $(document).ready(function() {
      $(".dropzone-container form span").html("<div class='pdf-image-wrapper'><img class='commonImage' src='assets/images/frame.png' /></div><button class='btn btn-default btn-upload-document' type='button'><img class='commonImage' src='assets/images/Vector.png'/> Upload the document</button><div><div class='drag-drop-desc'><small>or drag and drop</small></div><div class='document-type-desc'><small>(pdf, doc, docx)</small></div></div> ");
        Dropzone.options.Dropzone = {
            maxFiles: 1,
            acceptedFiles: "application/pdf",
            addRemoveLinks: true
        };

        $("body").on("click", ".btn-search", function(e) {
          e.preventDefault();
          var filename = $(".filename").val();
          if(filename !== "") {
            $(".loading-container").removeClass("hidden");
            $(".dropzone-container > form").addClass("hidden");
            $(".btn-search .search-loading").show();
            $(".btn-search span").text("");
            $(".btn-search img").hide();
            $(this).attr("disabled", "disabled");

            $.ajax({
              url:'search.php',
              data : {
                filename : filename
              },
              dataType:"json",
              type:"POST",
              success:function(response) {
                console.log(response);
                PDFFILE = filename;
                $(".home-container").hide();
                $(".search-container").show();
                Modernizr.addTest('async', function() {
                  try {
                    var result;
                    eval('let a = () => {result = "success"}; let b = async () => {await a()}; b()');
                    return result === 'success';
                  } catch (e) {
                    return false;
                  }
                });

                // test for async and fall back to code compiled to ES5 if they are not supported
                ['debounce.js', 'text-position.js'].forEach(function(js) {
                  var script = Modernizr.async ? js : js.replace('.js', '.ES5.js');
                  var scriptTag = document.createElement('script');
                  scriptTag.src = script;
                  scriptTag.type = 'text/javascript';
                  document.getElementsByTagName('head')[0].appendChild(scriptTag);
                });
                // showPDFViewer();
                $(".search-filename span").text(PDFFILE.replace("./uploads/", ""));
                $(".loading-container").addClass("hidden");
                $(".dropzone-container > form").addClass("hidden");
                $(".btn-search .search-loading").hide();
                $(".btn-search").removeAttr("disabled");
                $(".btn-search span").text("Search");
                $(".btn-search img").show();

                if(response[0].length > 0) {
                  var indexSearch = 0;
                  var optionHtml = '';
                  // searchWords.sort();
                  for (let i = 0; i < response[1].length; i++) {
                    optionHtml += '<option value = "'+response[1][i]+'" alt="'+response[2][i]+'">'+response[1][i]+'</option>'
                  }
                  var indexWord = 0;
                  $('#searchWords').html(optionHtml);
                  var tbody_html = "";
                  var index = 0;
                  var numSearch = 0;
                  var count = 0;
                  $("#totalSearch").text(response[3]);
                  if(response[3] > 0) {
                    indexSearch = 1;
                    numSearch++;
                    count++;
                  }
                  $("#countSearch").text(count);
                  $('#searchWords').val(response[1][indexSearch-1]);
                  $('#searchString').val(response[1][indexSearch-1]);
                  $('#searchString').attr('alt', response[2][indexSearch-1]);
                  var classNumber = [];
                  var imageName = [];
                  renderTable();
                  $(".search-result tbody").html(tbody_html);
                  $(".buttonCtl").click(function() {
                    if(count !== 0) {
                      count += Number($(this).attr('alt'));
                    }
                    if(count > response[3]) {
                      count--;
                      alert('Search End');
                      this.disabled = true;
                      e.preventDefault();
                    } else if(count <= 0) {
                      count = 1;
                      numSearch = 1;
                      indexSearch = 1;
                      alert('Search Limit');
                      $(this).prop('disabled', true);
                      e.preventDefault();
                    } else {
                      $(".buttonCtl").prop('disabled', false);
                      if(numSearch >= response[2][indexSearch-1] && $(this).attr('alt') === '1') {
                        numSearch = 1;
                        indexSearch += Number($(this).attr('alt'));
                        $('#searchWords').val(response[1][indexSearch-1]);
                        $('#searchString').val(response[1][indexSearch-1]);
                        $('#searchString').attr('alt', response[2][indexSearch-1]);
                      } else if(numSearch <= 1 && $(this).attr('alt') === '-1') {
                        numSearch = response[2][indexSearch-2];
                        indexSearch += Number($(this).attr('alt'));
                        $('#searchWords').val(response[1][indexSearch-1]);
                        $('#searchString').val(response[1][indexSearch-1]);
                        $('#searchString').attr('alt', response[2][indexSearch-1]);
                      } else {
                        numSearch += Number($(this).attr('alt'));
                      }
                      tbody_html = "";
                      index = 0;
                      renderTable();
                      $(".search-result tbody").html(tbody_html);
                      $("#countSearch").text(count);
                    }
                    
                  })
                  $('#searchResultModal').modal('show');
                  function renderTable() {
                    for (let i = 0; i < response[0].length; i++) {								
                      if(response[0][i][3].includes($('#searchString').val())) {
                        index++;
                        classNumber = [];
                        imageName = [];
                        if(response[0][i][4].includes('.') && response[0][i][4].indexOf('.') < 3) {
                          classNumber.push(response[0][i][4].slice(0,4).trim());
                        } else {
                          classNumber.push(response[0][i][4].slice(0,1).trim());
                        }
                        if(response[0][i][4].includes('(') && response[0][i][4].includes(')')) {
                          var secondaryNumbers = response[0][i][4].slice(response[0][i][4].indexOf('(')+1, response[0][i][4].indexOf(')'));
                          secondaryNumbers.split(',').forEach(nums => {
                            classNumber.push(nums.trim());
                          })
                        }
                        classNumber.forEach(classNum => {
                          var flag = false;
                          response[4].some(file => {
                            if(file.includes('Class '+classNum)) {
                              !flag && imageName.push('assets/images/Hazard_labels/'+file);
                              flag = true;
                            }
                          })
                          if(!flag) {
                            response[4].some(file => {
                              if(classNum.includes('.') && file.includes('Class '+classNum.slice(0, -1))) {
                                !flag && imageName.push('assets/images/Hazard_labels/'+file);
                                flag = true;
                              }
                            })	
                          }
                        })
                        
                        tbody_html += "<tr><td>" + parseInt(index) + ".</td>";
                        tbody_html += "<td>" + response[0][i][1] + "</td><td>" + response[0][i][2] + "</td>";
                        tbody_html += "<td>" + response[0][i][4] + "</td>";
                        tbody_html += "<td class='text-center'>";
                        imageName.forEach(image => {
                          tbody_html += "<img id='labelImage' src='" + image + "'>";
                        })
                        tbody_html += "</td></tr>";
                      }
                    }
                  }							
                } else {
                  alert("No matching keywords");
                }
              }
            });
          } else {
            alert("No file uploaded.");
          }
        });
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>