<?php
session_start();
include "../db/adminconfig.php";

function back($msg){
  $_SESSION["adm_verify_msg"] = $msg;
  header("Location: ../html/adminverification.php");
  exit;
}

$pending = $_SESSION["tb_admin_reg_pending"] ?? null;
if(!$pending){
  header("Location: ../html/adminregister.php");
  exit;
}

if(!isset($_POST["verify"])){
  header("Location: ../html/adminverification.php");
  exit;
}

$email = $conn->real_escape_string($pending["email"]);
$otp_in = trim($_POST["otp"] ?? "");
$otp_sess = $_SESSION["tb_admin_reg_otp"] ?? "";

if($otp_in == "" || $otp_sess == ""){
  back("Session expired. Try again.");
}

/* ✅ get latest unused OTP */
$q = $conn->query("SELECT * FROM otp_requests
                   WHERE email='$email' AND purpose='admin_register' AND is_used=0
                   ORDER BY id DESC LIMIT 1");

if(!$q || $q->num_rows==0){
  back("OTP not found. Try again.");
}

$row = $q->fetch_assoc();

if(strtotime($row["expires_at"]) < time()){
  back("OTP expired. Please register again.");
}

if($otp_in !== $row["otp_code"] || $otp_in !== $otp_sess){
  back("Wrong OTP!");
}

/* ✅ mark otp used */
$conn->query("UPDATE otp_requests SET is_used=1 WHERE id=".$row["id"]);

/* ✅ insert admin now */
$name  = $conn->real_escape_string($pending["name"]);
$phone = $conn->real_escape_string($pending["phone"]);
$hash  = password_hash($pending["pass"], PASSWORD_DEFAULT);

$conn->query("INSERT INTO admins(name,email,phone,password_hash,created_at)
              VALUES('$name','$email','$phone','$hash',NOW())");

/* ✅ clear session */
unset($_SESSION["tb_admin_reg_pending"], $_SESSION["tb_admin_reg_otp"]);

$_SESSION["adm_login_msg"] = "Admin verified successfully. Please login.";
header("Location: ../html/adminlogin.php");
exit;
?>
