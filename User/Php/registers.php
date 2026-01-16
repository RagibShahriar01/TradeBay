<?php
session_start();

include "../db/config.php";
include "mailer.php"; // ✅ PHPMailer helper (User/Php/mailer.php)

function clean($v){ return trim($v); }

$success = $error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name   = $conn->real_escape_string(clean($_POST["name"] ?? ""));
    $email  = $conn->real_escape_string(clean($_POST["email"] ?? ""));
    $phone  = $conn->real_escape_string(clean($_POST["phone"] ?? ""));
    $gender = $conn->real_escape_string(clean($_POST["gender"] ?? ""));
    $pass   = clean($_POST["password"] ?? "");
    $cpass  = clean($_POST["confirm_password"] ?? "");

    if($name=="" || $email=="" || $phone=="" || $gender=="" || $pass=="" || $cpass==""){
        $error = "All fields are required!";
    }
    elseif(strlen($pass) < 4){
        $error = "Password must be at least 4 characters!";
    }
    elseif($pass !== $cpass){
        $error = "Password and confirm password do not match!";
    }
    else {

        $chk = $conn->query("SELECT id FROM users WHERE email='$email' LIMIT 1");
        if($chk && $chk->num_rows > 0){
            $error = "Email already exists!";
        }
        else {

            $otp = strval(rand(1000, 9999));
            $expires = date("Y-m-d H:i:s", time() + 300); // 5 minutes

            // save pending data in session
            $_SESSION["tb_user_reg_pending"] = [
                "name"   => $name,
                "email"  => $email,
                "phone"  => $phone,
                "gender" => $gender,
                "pass"   => $pass
            ];
            $_SESSION["tb_user_reg_otp"] = $otp;

            // store otp in DB
            $conn->query("INSERT INTO otp_requests(email,otp_code,purpose,expires_at)
                          VALUES('$email','$otp','user_register','$expires')");

            // ✅ Send OTP using PHPMailer SMTP
            $body = "
              <h3>TradeBay OTP Verification</h3>
              <p>Your OTP is: <b>$otp</b></p>
              <p>Valid for 5 minutes.</p>
            ";

            $sent = tb_send_mail($email, $name, "TradeBay OTP Verification", $body);

            if(!$sent){
                $_SESSION["tb_user_reg_error"] = "OTP could not be sent. Please try again.";
                header("Location: ../html/register.php");
                exit;
            }

            header("Location: ../html/verification.php");
            exit;
        }
    }
}

// if any error happens, go back to register
$_SESSION["tb_user_reg_error"] = $error;
header("Location: ../html/register.php");
exit;
?>
