<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$id = (int)($_POST["id"] ?? 0);
if($id>0){
  // because users->listings/orders are ON DELETE CASCADE,
  // deleting user will delete all listings + all orders + order_items
  $conn->query("DELETE FROM users WHERE id=$id");
  $_SESSION["adm_user_msg"] = "User deleted (and all related data)!";
}
header("Location: ../html/deleteuser.php");
exit;
?>
