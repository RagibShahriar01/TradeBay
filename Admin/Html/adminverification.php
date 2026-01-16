<?php
session_start();
$pending = $_SESSION["tb_admin_reg_pending"] ?? null;
if(!$pending){
  header("Location: register.php");
  exit;
}
$msg = $_SESSION["adm_verify_msg"] ?? "";
unset($_SESSION["adm_verify_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin OTP Verification</title>
  <link rel="stylesheet" href="../../user/Css/verification.css">
  <link rel="stylesheet" href="../css/adminverification.css">
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
      <h3>Admin OTP Verification</h3>

      <p class="otp-info">
        OTP sent to: <b><?php echo htmlspecialchars($pending["email"]); ?></b>
      </p>

      <form method="post" action="../php/adminverifications.php">
        <label><b>Enter OTP</b></label>
        <input type="text" name="otp" required>
        <button type="submit" name="verify">Verify</button>
      </form>

      <p class="msg"><?php echo $msg; ?></p>
    </div>
  </div>

</body>
</html>
