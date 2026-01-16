<?php
session_start();
include "../db/adminconfig.php";

$pending = $_SESSION["tb_admin_reg_pending"] ?? null;
if(!$pending){ header("Location: ../html/adminregister.php"); exit; }

$otp_in = trim($_POST["otp"] ?? "");
$otp_sess = $_SESSION["tb_admin_reg_otp"] ?? "";
$email = $conn->real_escape_string($pending["email"]);

$row = $conn->query("SELECT * FROM otp_requests
                     WHERE email='$email' AND purpose='adminregister' AND is_used=0
                     ORDER BY id DESC LIMIT 1")->fetch_assoc();

if(!$row){
  $_SESSION["adm_verify_msg"]="OTP not found.";
  header("Location: ../html/adminverification.php"); exit;
}
if(strtotime($row["expires_at"]) < time()){
  $_SESSION["adm_verify_msg"]="OTP expired.";
  header("Location: ../html/adminverification.php"); exit;
}
if($otp_in !== $row["otp_code"] || $otp_in !== $otp_sess){
  $_SESSION["adm_verify_msg"]="Wrong OTP!";
  header("Location: ../html/adminverification.php"); exit;
}

$name = $conn->real_escape_string($pending["name"]);
$phone = $conn->real_escape_string($pending["phone"]);
$hash = password_hash($pending["pass"], PASSWORD_DEFAULT);

$ins = $conn->query("INSERT INTO admins(name,email,phone,password_hash)
                     VALUES('$name','$email','$phone','$hash')");
if(!$ins){
  $_SESSION["adm_verify_msg"]="DB Error: ".$conn->error;
  header("Location: ../html/adminverification.php"); exit;
}

$conn->query("UPDATE otp_requests SET is_used=1 WHERE id=".$row["id"]);

unset($_SESSION["tb_admin_reg_pending"], $_SESSION["tb_admin_reg_otp"]);

$_SESSION["admin_id"] = $conn->insert_id;
$_SESSION["admin_email"] = $email;
$_SESSION["admin_name"] = $pending["name"];

header("Location: ../html/admindashboard.php");
exit;
?>
