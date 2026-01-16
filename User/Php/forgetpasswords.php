<?php
session_start();

include "../db/config.php";
include "mailer.php"; // ✅ PHPMailer helper (User/Php/mailer.php)

function back(){
  header("Location: ../html/forgetpassword.php");
  exit;
}

/* =========================
   STAGE 1: SEND OTP
========================= */
if(isset($_POST["send_otp"])){

    $email = $conn->real_escape_string(trim($_POST["email"] ?? ""));
    if($email == ""){
        $_SESSION["tb_fp_msg"] = "Email required!";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    // check user exists
    $u = $conn->query("SELECT id FROM users WHERE email='$email' LIMIT 1");
    if(!$u || $u->num_rows == 0){
        $_SESSION["tb_fp_msg"] = "Email not found!";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    // generate OTP (4 digits) + 5 minutes expire
    $otp = strval(rand(1000, 9999));
    $expires = date("Y-m-d H:i:s", time() + 300);

    // save in session
    $_SESSION["tb_fp_email"] = $email;
    $_SESSION["tb_fp_otp"]   = $otp;
    $_SESSION["tb_fp_stage"] = 2;

    // store in DB (otp_requests)
    $conn->query("INSERT INTO otp_requests(email,otp_code,purpose,expires_at)
                  VALUES('$email','$otp','user_reset','$expires')");

    // ✅ Send OTP using PHPMailer SMTP
    $body = "
      <h3>TradeBay Password Reset</h3>
      <p>Your 4-digit OTP is: <b>$otp</b></p>
      <p>Valid for 5 minutes.</p>
    ";

    $sent = tb_send_mail($email, "", "TradeBay Password Reset OTP", $body);

    if(!$sent){
        $_SESSION["tb_fp_msg"] = "OTP could not be sent. Please try again.";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    $_SESSION["tb_fp_msg"] = "OTP sent. Check your email.";
    back();
}


/* =========================
   STAGE 2: VERIFY OTP
========================= */
if(isset($_POST["verify_otp"])){

    $otp_in = trim($_POST["otp"] ?? "");
    $email = $conn->real_escape_string($_SESSION["tb_fp_email"] ?? "");
    $otp_sess = $_SESSION["tb_fp_otp"] ?? "";

    if($email == "" || $otp_sess == ""){
        $_SESSION["tb_fp_msg"] = "Session expired. Try again.";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    $res = $conn->query("SELECT * FROM otp_requests
                         WHERE email='$email' AND purpose='user_reset' AND is_used=0
                         ORDER BY id DESC LIMIT 1");

    $row = $res ? $res->fetch_assoc() : null;

    if(!$row){
        $_SESSION["tb_fp_msg"] = "OTP not found. Try again.";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    if(strtotime($row["expires_at"]) < time()){
        $_SESSION["tb_fp_msg"] = "OTP expired. Try again.";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    // must match both DB OTP and session OTP
    if($otp_in !== $row["otp_code"] || $otp_in !== $otp_sess){
        $_SESSION["tb_fp_msg"] = "Wrong OTP!";
        $_SESSION["tb_fp_stage"] = 2;
        back();
    }

    $conn->query("UPDATE otp_requests SET is_used=1 WHERE id=".(int)$row["id"]);

    $_SESSION["tb_fp_stage"] = 3;
    $_SESSION["tb_fp_msg"] = "OTP verified. Now set a new password.";
    back();
}


/* =========================
   STAGE 3: UPDATE PASSWORD
========================= */
if(isset($_POST["update_password"])){

    $email = $conn->real_escape_string($_SESSION["tb_fp_email"] ?? "");
    if($email == ""){
        $_SESSION["tb_fp_msg"] = "Session expired. Try again.";
        $_SESSION["tb_fp_stage"] = 1;
        back();
    }

    $new = trim($_POST["newpass"] ?? "");
    $cp  = trim($_POST["cpass"] ?? "");

    if(strlen($new) < 4){
        $_SESSION["tb_fp_msg"] = "Password must be at least 4 characters!";
        $_SESSION["tb_fp_stage"] = 3;
        back();
    }

    if($new !== $cp){
        $_SESSION["tb_fp_msg"] = "Passwords do not match!";
        $_SESSION["tb_fp_stage"] = 3;
        back();
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET password_hash='$hash' WHERE email='$email'");

    // clear session for forgot password
    unset($_SESSION["tb_fp_stage"], $_SESSION["tb_fp_email"], $_SESSION["tb_fp_otp"]);

    $_SESSION["tb_login_msg"] = "Password updated. Please login.";
    header("Location: ../html/login.php");
    exit;
}


// fallback
$_SESSION["tb_fp_stage"] = 1;
back();
?>
