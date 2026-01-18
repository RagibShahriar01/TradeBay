<?php
include "auth_guard.php";

$id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

if ($id > 0 && isset($_SESSION["cart"][$id])) {
  unset($_SESSION["cart"][$id]);
}

header("Location: ../html/cart.php");
exit;
?>