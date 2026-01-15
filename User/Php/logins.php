<?php
session_start();
include "../db/config.php";



$email = $conn->real_escape_string(trim($_POST["email"] ?? ""));
$pass = trim($_POST["password"] ?? "");
$next = $_POST["next"] ?? "../html/home.php";



$q = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
if(!$q || $q->num_rows==0){
    $_SESSION["tb_login_msg"] = "Invalid email or password!";
    header("Location: ../html/login.php?next=".urlencode($next)); exit;
}



$u = $q->fetch_assoc();
if(!password_verify($pass, $u["password_hash"])){
    $_SESSION["tb_login_msg"] = "Invalid email or password!";
    header("Location: ../html/login.php?next=".urlencode($next)); exit;
}



$_SESSION["user_id"] = (int)$u["id"];
$_SESSION["user_email"] = $u["email"];
$_SESSION["user_name"] = $u["name"];



header("Location: ".$next);
exit;
?>
