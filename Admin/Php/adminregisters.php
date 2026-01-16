<?php
session_start();
include "../db/adminconfig.php";

$name = $conn->real_escape_string(trim($_POST["name"] ?? ""));
$email = $conn->real_escape_string(trim($_POST["email"] ?? ""));
$phone = $conn->real_escape_string(trim($_POST["phone"] ?? ""));
$pass = trim($_POST["password"] ?? "");
$cpass = trim($_POST["cpassword"] ?? "");

if($name=="" || $email=="" || $phone=="" || $pass=="" || $cpass==""){
  $_SESSION["adm_reg_msg"]="All fields are required!";
  header("Location: ../html/adminregister.php"); exit;
}
if(strlen($pass) < 4){
  $_SESSION["adm_reg_msg"]="Password must be at least 4 characters!";
  header("Location: ../html/adminregister.php"); exit;
}
if($pass !== $cpass){
  $_SESSION["adm_reg_msg"]="Passwords do not match!";
  header("Location: ../html/adminregister.php"); exit;
}

$chk = $conn->query("SELECT id FROM admins WHERE email='$email' LIMIT 1");
if($chk && $chk->num_rows>0){
  $_SESSION["adm_reg_msg"]="Admin email already exists!";
  header("Location: ../html/adminregister.php"); exit;
}

$otp = strval(rand(1000,9999));
$expires = date("Y-m-d H:i:s", time()+300);

$_SESSION["tb_admin_reg_pending"] = ["name"=>$name,"email"=>$email,"phone"=>$phone,"pass"=>$pass];
$_SESSION["tb_admin_reg_otp"] = $otp;

$conn->query("INSERT INTO otp_requests(email,otp_code,purpose,expires_at)
              VALUES('$email','$otp','adminregister','$expires')");

@mail($email, "TradeBay Admin OTP", "Your Admin OTP is: ".$otp." (valid for 5 minutes)");

header("Location: ../html/adminverification.php");
exit;
?>
