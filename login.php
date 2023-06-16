<?php
  session_start();
  include 'config.php';
  $_SESSION["error"] = "";
  if(isset($_POST["email"])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $pass = hash('sha1', $pass);
    $query = "SELECT * FROM users where email='".$email."' and password='".$pass."'";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    if($result->num_rows > 0) {
      $_SESSION["error"] = "";
      header('Location:home.php');
      $_SESSION["email"] = $user["email"];
      $_SESSION["role"] = $user["role"];
    } else {
      $_SESSION["error"] = "Wrong credential. Please try again.";
    }
  }
?>
<html>

<head>
  <title>Search PDF into Google Spreadsheet api</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap.min.css">

  <!--------- Dropzone JS and CSS file --------->
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/custom.css">

</head>

<body>
  <section class="header">
    <div class="header-main">
      <div class="logo"></div>
      <div class="menu">
        <ul>
          <li class="active">Search</li>
          <li>Convert</li>
          <li>Merge</li>
          <li>Edit</li>
          <li>Sign</li>
        </ul>
      </div>
      <div>
        <a href="login.php" class="btn btn-outline-danger btn-login">Login</a>
      </div>
    </div>
  </section>
  <section class="main p-5">
    <div class="container home-container">
      <div class="dropzone-title text-center">
        <h1>
          Manifest Search.
        </h1>
        <p>Find dangerous goods in your manifest</p>
      </div>
			<div class="home-intro p-4">
      <?php
        if(isset($_SESSION["error"]) && $_SESSION["error"] != "") {
      ?>
        <div class="alert-danger p-4 mb-2"><?php echo $_SESSION["error"];?></div>
      <?php
        }      
      ?>
        <form class="horizontal" action="login.php" method="POST">
          <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" required/>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required/>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-danger">Login</button>
          </div>
        </form>
			</div>
    </div>
  </section>
  <section class="footer">
    <div class="footer-main">
      <div class="logo">Copyright &copy; 2022 - Manifest Search</div>
      <div class="menu">
        <ul>
          <li>Privacy Notice</li>
          <li>Terms & Conditions</li>
          <li>Imprint</li>
          <li>Contact Us</li>
        </ul>
      </div>
    </div>
  </section>
  <input type="hidden" class="filename" />
  <script src="assets/jquery.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
  <!----------- Custom JS --------------->
</body>

</html>
<script>
$(document).ready(function() {

});
</script>