<?php
session_start();
$stage = $_SESSION["tb_fp_stage"] ?? 1; // 1=email, 2=otp, 3=newpass
$msg = $_SESSION["tb_fp_msg"] ?? "";
unset($_SESSION["tb_fp_msg"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../Css/forgetpassword.css">
</head>

<body>
  <div class="logo-container">
    <a href="http://localhost/TradeBay/User/Html/home.php">
      <span style="color: blue;">T</span><span style="color: green;">r</span><span style="color: red;">a</span><span style="color: blue;">d</span><span style="color: red;">e</span><span style="color: green;">B</span><span style="color: blue;">a</span><span style="color: orange;">y</span>
    </a>
  </div>

  <div class="form-container">
    <div class="login-card">
      <h3>Forgot Password</h3><br>

      <p style="color:red;margin-bottom:10px;"><?php echo $msg; ?></p>

      <?php if($stage==1){ ?>

        <form method="post" action="../php/forgetpasswords.php">
          <label><b>Your Email</b></label>
          <input type="email" name="email" placeholder="Enter your email" required>
          <button type="submit" name="send_otp">Send OTP</button>
        </form>

      <?php } elseif($stage==2){ ?>

        <p style="font-size:14px;color:gray;margin-bottom:10px;">
          OTP sent to: <b><?php echo htmlspecialchars($_SESSION["tb_fp_email"] ?? ""); ?></b>
        </p>

        <form method="post" action="../php/forgetpasswords.php">
          <label><b>Enter OTP</b></label>
          <input type="text" name="otp" placeholder="4 digit OTP" required>
          <button type="submit" name="verify_otp">Verify OTP</button>
        </form>

      <?php } else { ?>

        <form method="post" action="../php/forgetpasswords.php">
          <label><b>New Password</b></label>
          <input type="password" name="newpass" placeholder="new password" required>

          <label><b>Confirm Password</b></label>
          <input type="password" name="cpass" placeholder="confirm password" required>

          <button type="submit" name="update_password">Update Password</button>
        </form>

      <?php } ?>

      <div class="links">
        <a href="login.php">Back to Login</a>
      </div>

    </div>
  </div>

</body>
</html>
