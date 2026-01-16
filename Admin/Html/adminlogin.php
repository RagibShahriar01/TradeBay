<?php
session_start();
$msg = $_SESSION["adm_login_msg"] ?? "";
unset($_SESSION["adm_login_msg"]);
$next = $_GET["next"] ?? "../html/admindashboard.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../../user/Css/login.css">
  <link rel="stylesheet" href="../css/adminlogin.css">
</head>
<body>

  <div class="logo-container">
    <a href="#">
      <span style="color: blue;">T</span>
      <span style="color: green;">r</span>
      <span style="color: red;">a</span>
      <span style="color: blue;">d</span>
      <span style="color: red;">e</span>
      <span style="color: green;">B</span>
      <span style="color: blue;">a</span>
      <span style="color: orange;">y</span>
    </a>
  </div>

  <div class="form-container">
    <div class="login-card">
      <h3>Admin Login</h3>

      <p class="msg"><?php echo $msg; ?></p>

      <form method="post" action="../php/adminlogins.php">
        <input type="hidden" name="next" value="<?php echo htmlspecialchars($next); ?>">

        <label><b>Email</b></label>
        <input type="email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" name="password" required>

        <button type="submit" name="login">LOG IN</button>
      </form>

      <div class="links center-links">
        <a href="adminregister.php">Create Admin</a>
      </div>
    </div>
  </div>

</body>
</html>
