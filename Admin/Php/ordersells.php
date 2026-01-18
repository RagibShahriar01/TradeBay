<?php
include "admin_guard.php";
include "../db/adminconfig.php";

if(!isset($_POST["sell"])) {
  header("Location: ../html/orders.php");
  exit;
}

$orderItemId = (int)($_POST["order_item_id"] ?? 0);
$listingId   = (int)($_POST["listing_id"] ?? 0);

if($orderItemId <= 0 || $listingId <= 0){
  $_SESSION["adm_order_msg"] = "Invalid request.";
  header("Location: ../html/orders.php");
  exit;
}

// mark item sold
$u = $conn->prepare("UPDATE order_items SET status='sold' WHERE id=? LIMIT 1");
$u->bind_param("i", $orderItemId);
$u->execute();

// remove listing so it disappears from home
$d = $conn->prepare("DELETE FROM listings WHERE id=? LIMIT 1");
$d->bind_param("i", $listingId);
$d->execute();

// (optional) if all items of that order are sold -> update orders.status = sold
$getOrder = $conn->prepare("SELECT order_id FROM order_items WHERE id=? LIMIT 1");
$getOrder->bind_param("i", $orderItemId);
$getOrder->execute();
$or = $getOrder->get_result();
if($or && $or->num_rows>0){
  $oid = (int)$or->fetch_assoc()["order_id"];

  $check = $conn->prepare("SELECT COUNT(*) AS pending_count FROM order_items WHERE order_id=? AND status!='sold'");
  $check->bind_param("i", $oid);
  $check->execute();
  $cr = $check->get_result()->fetch_assoc();
  if((int)$cr["pending_count"] === 0){
    $up = $conn->prepare("UPDATE orders SET status='sold' WHERE id=? LIMIT 1");
    $up->bind_param("i", $oid);
    $up->execute();
  }
}

$_SESSION["adm_order_msg"] = "Marked as sold and removed from listings.";
header("Location: ../html/orders.php");
exit;
