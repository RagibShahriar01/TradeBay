<?php
session_start();
if(!isset($_SESSION["user_id"])){
    $next = $_SERVER["REQUEST_URI"];
    header("Location: ../html/login.php?next=" . urlencode($next));
    exit;
}
?>
