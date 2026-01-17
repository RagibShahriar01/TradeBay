<?php
session_start();
$pending = $_SESSION["tb_user_reg_pending"] ?? null;
if(!$pending){ header("Location: register.php"); exit; }

$msg = $_SESSION["tb_user_verify_msg"] ?? "";
unset($_SESSION["tb_user_verify_msg"]);
?>



<!DOCTYPE html>
<html>

<head>
  <title>Verify OTP</title>
  <link rel="stylesheet" href="../Css/verification.css">
</head>


<body>

  <div class="logo-container">
    <a href="#"><span style="color: blue;">T</span><span style="color: green;">r</span><span style="color: red;">a</span><span style="color: blue;">d</span><span style="color: red;">e</span><span style="color: green;">B</span><span style="color: blue;">a</span><span style="color: orange;">y</span></a>
  </div>

  <div class="form-container">
    <div class="login-card">
      <h3>OTP Verification</h3>
      <p style="font-size:14px;color:gray;margin-bottom:12px;">
        We sent a 4-digit OTP to: <b><?php echo htmlspecialchars($pending["email"]); ?></b>
      </p>


      <form method="post" action="../php/verifications.php">
        <label><b>Enter OTP</b></label>
        <input type="text" name="otp" placeholder="4 digit OTP" required>

        <button type="submit" name="verify">Verify OTP</button>
      </form>

      
      <p style="color:red;margin-top:10px;"><?php echo $msg; ?></p>
    </div>
  </div>


</body>
</html>
