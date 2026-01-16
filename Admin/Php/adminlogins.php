<?php
session_start();
include "../db/adminconfig.php";

$email = $conn->real_escape_string(trim($_POST["email"] ?? ""));
$pass  = trim($_POST["password"] ?? "");
$next  = $_POST["next"] ?? "../html/admindashboard.php";

$q = $conn->query("SELECT * FROM admins WHERE email='$email' LIMIT 1");


if(!$q || $q->num_rows==0){
  $_SESSION["adm_login_msg"]="Invalid email or password!";
  header("Location: ../html/adminlogin.php?next=".urlencode($next)); exit;
}
$a = $q->fetch_assoc();
if(!password_verify($pass, $a["password_hash"])){
  $_SESSION["adm_login_msg"]="Invalid email or password!";
  header("Location: ../html/adminlogin.php?next=".urlencode($next)); exit;
}

$_SESSION["admin_id"] = (int)$a["id"];
$_SESSION["admin_email"] = $a["email"];
$_SESSION["admin_name"] = $a["name"];

header("Location: ".$next);
exit;
?>
