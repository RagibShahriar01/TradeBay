<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$id = (int)($_POST["id"] ?? 0);
if($id>0){
  $conn->query("DELETE FROM listings WHERE id=$id");
  $_SESSION["adm_app_msg"] = "Product deleted!";
}
header("Location: ../html/approved.php");
exit;
?>
