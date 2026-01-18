<?php
session_start();
include "../db/adminconfig.php";

/* ✅ Use the SAME PHPMailer helper used by user */
include __DIR__ . "/../../User/Php/mailer.php";

function clean($v){ return trim($v); }

function back($msg){
  $_SESSION["adm_reg_msg"] = $msg;
  header("Location: ../html/adminregister.php");
  exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST"){
  header("Location: ../html/adminregister.php");
  exit;
}

$name  = $conn->real_escape_string(clean($_POST["name"] ?? ""));
$email = $conn->real_escape_string(clean($_POST["email"] ?? ""));
$phone = $conn->real_escape_string(clean($_POST["phone"] ?? ""));
$pass  = clean($_POST["password"] ?? "");
$cpass = clean($_POST["cpassword"] ?? "");

if($name=="" || $email=="" || $phone=="" || $pass=="" || $cpass==""){
  back("All fields are required!");
}
if(strlen($pass) < 4){
  back("Password must be at least 4 characters!");
}
if($pass !== $cpass){
  back("Password and confirm password do not match!");
}

/* ✅ admin email must be unique */
$chk = $conn->query("SELECT id FROM admins WHERE email='$email' LIMIT 1");
if($chk && $chk->num_rows > 0){
  back("Email already exists!");
}

/* ✅ generate OTP */
$otp = strval(rand(1000,9999));
$expires = date("Y-m-d H:i:s", time() + 300); // 5 minutes

/* ✅ store pending admin data in session */
$_SESSION["tb_admin_reg_pending"] = [
  "name"=>$name,
  "email"=>$email,
  "phone"=>$phone,
  "pass"=>$pass
];
$_SESSION["tb_admin_reg_otp"] = $otp;

/* ✅ store OTP in DB */
$conn->query("INSERT INTO otp_requests(email,otp_code,purpose,expires_at)
              VALUES('$email','$otp','admin_register','$expires')");

/* ✅ send OTP email using PHPMailer */
$body = "
  <p>Your 4-digit OTP is: <b>$otp</b></p>
  <p>Valid for 5 minutes.</p>
";

$sent = tb_send_mail($email, $name, "TradeBay Admin OTP Verification", $body);

if(!$sent){
  back("OTP could not be sent. Please try again.");
}

/* ✅ go to admin verification page */
header("Location: ../html/adminverification.php");
exit;
?>
