<?php
session_start();
$next = $_GET["next"] ?? "../html/home.php";
$msg = $_SESSION["tb_login_msg"] ?? "";
unset($_SESSION["tb_login_msg"]);
?>


<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="../Css/login.css">
</head>


<body>
  <div class="logo-container">
    <a href="http://localhost/TradeBay/User/Html/home.php"><span style="color: blue;">T</span><span style="color: green;">r</span><span style="color: red;">a</span><span style="color: blue;">d</span><span style="color: red;">e</span><span style="color: green;">B</span><span style="color: blue;">a</span><span style="color: orange;">y</span></a>
  </div>

  <div class="form-container">
    <div class="login-card">
      <h3>User Login</h3>


      <form method="post" action="../php/logins.php">
        <input type="hidden" name="next" value="<?php echo htmlspecialchars($next); ?>">

        <label><b>E-mail Address</b></label>
        <input type="email" name="email" placeholder="your email" required>

        <label><b>Password</b></label>
        <input type="password" name="password" placeholder="your password" required>

        <button type="submit" name="login">LOG IN</button>
      </form>

      <p style="color:red;margin-top:10px;"><?php echo $msg; ?></p>

      <div class="links">
        <a href="register.php">Register</a>
        <a href="forgetpassword.php">Forgot Password?</a>
      </div>
    </div>
  </div>

  
</body>
</html>
