<?php
session_start();
include "../db/config.php";

$pending = $_SESSION["tb_user_reg_pending"] ?? null;
if(!$pending){ header("Location: ../html/register.php"); exit; }

$otp_in = trim($_POST["otp"] ?? "");
$otp_sess = $_SESSION["tb_user_reg_otp"] ?? "";

$email = $conn->real_escape_string($pending["email"]);

$row = $conn->query("SELECT * FROM otp_requests
                     WHERE email='$email' AND purpose='user_register'
                     AND is_used=0
                     ORDER BY id DESC LIMIT 1")->fetch_assoc();


if(!$row){
    $_SESSION["tb_user_verify_msg"] = "OTP not found. Please register again.";
    header("Location: ../html/verification.php"); exit;
}

if(strtotime($row["expires_at"]) < time()){
    $_SESSION["tb_user_verify_msg"] = "OTP expired. Please register again.";
    header("Location: ../html/verification.php"); exit;
}


if($otp_in !== $row["otp_code"] || $otp_in !== $otp_sess){
    $_SESSION["tb_user_verify_msg"] = "Wrong OTP!";
    header("Location: ../html/verification.php"); exit;
}


// Insert user
$name = $conn->real_escape_string($pending["name"]);
$phone = $conn->real_escape_string($pending["phone"]);
$gender = $conn->real_escape_string($pending["gender"]);
$hash = password_hash($pending["pass"], PASSWORD_DEFAULT);

$ins = $conn->query("INSERT INTO users(name,email,phone,gender,password_hash)
                     VALUES('$name','$email','$phone','$gender','$hash')");

if(!$ins){
    $_SESSION["tb_user_verify_msg"] = "DB error: ".$conn->error;
    header("Location: ../html/verification.php"); exit;
}

$conn->query("UPDATE otp_requests SET is_used=1 WHERE id=".$row["id"]);

$user_id = $conn->insert_id;

// auto login
unset($_SESSION["tb_user_reg_pending"], $_SESSION["tb_user_reg_otp"]);
$_SESSION["user_id"] = $user_id;
$_SESSION["user_email"] = $pending["email"];
$_SESSION["user_name"] = $pending["name"];

header("Location: ../html/home.php");
exit;
?>
