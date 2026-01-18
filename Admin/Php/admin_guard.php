<?php
session_start();
if(!isset($_SESSION["admin_id"])){
  $next = $_SERVER["REQUEST_URI"];
  header("Location: ../html/adminlogin.php?next=" . urlencode($next));
  exit;
}
?>
