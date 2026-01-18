<?php
session_start();
$msg = $_SESSION["adm_reg_msg"] ?? "";
unset($_SESSION["adm_reg_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Register</title>
  <link rel="stylesheet" href="../../user/Css/register.css">
  <link rel="stylesheet" href="../css/adminregister.css">
</head>
<body>

  <div class="logo-container">
    <a href="#"><span style="color: blue;">T</span><span style="color: green;">r</span><span style="color: red;">a</span><span style="color: blue;">d</span><span style="color: red;">e</span><span style="color: green;">B</span><span style="color: blue;">a</span><span style="color: orange;">y</span></a>
  </div>

  <div class="form-container">
    <div class="login-card">
      <h3>Admin Register</h3>

      <p class="msg"><?php echo $msg; ?></p>

      <form method="post" action="../php/adminregisters.php">
        <label><b>Name</b></label>
        <input type="text" name="name" required>

        <label><b>Email</b></label>
        <input type="email" name="email" required>

        <label><b>Phone</b></label>
        <input type="tel" name="phone" required>

        <label><b>Password</b></label>
        <input type="password" name="password" required>

        <label><b>Confirm Password</b></label>
        <input type="password" name="cpassword" required>

        <button type="submit" name="submit">REGISTER</button>
      </form>

      <div class="links register-links">
        <span>Already admin?</span>
        <a href="adminlogin.php">Login</a>
      </div>
    </div>
  </div>

</body>
</html>
