<?php
include "auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];
$shipping = 60.00;

$buyId = isset($_GET["buy_id"]) ? (int)$_GET["buy_id"] : 0;

function clean($v){
  return trim($v ?? "");
}

if(!isset($_POST["place_order"])){
  header("Location: ../html/checkout.php");
  exit;
}

$first = clean($_POST["first_name"]);
$last  = clean($_POST["last_name"]);
$phone = clean($_POST["phone"]);
$email = clean($_POST["email"]);
$addr  = clean($_POST["address"]);
$city  = clean($_POST["city"]);
$area  = clean($_POST["area"]);
$postc = clean($_POST["postcode"]);
$notes = clean($_POST["notes"]);
$pay   = clean($_POST["payment_method"]);
$bkNo  = clean($_POST["bkash_no"]);
$bkTrx = clean($_POST["bkash_trx"]);

// required fields (postcode + notes optional)
if($first=="" || $last=="" || $phone=="" || $email=="" || $addr=="" || $city=="" || $area=="" || $pay==""){
  die("Please fill all required fields.");
}

// payment rule
if($pay === "bkash"){
  if($bkNo=="" || $bkTrx==""){
    die("bKash Number and Transaction ID are required for bKash payment.");
  }
} else {
  $bkNo = "";
  $bkTrx = "";
}

// build items
$items = [];
$subtotal = 0.00;

if($buyId > 0){
  $st = $conn->prepare("SELECT id, product_name, price, image_path FROM listings WHERE id=? AND status='approved' LIMIT 1");
  $st->bind_param("i", $buyId);
  $st->execute();
  $r = $st->get_result();
  if($r && $r->num_rows>0){
    $p = $r->fetch_assoc();
    $items[] = ["id"=>$p["id"], "name"=>$p["product_name"], "price"=>(float)$p["price"], "qty"=>1, "image"=>$p["image_path"]];
    $subtotal += (float)$p["price"];
  }
} else {
  $cart = $_SESSION["cart"] ?? [];
  if(!empty($cart)){
    $ids = array_map("intval", array_keys($cart));
    $in = implode(",", $ids);
    $q = $conn->query("SELECT id, product_name, price, image_path FROM listings WHERE status='approved' AND id IN ($in)");
    while($p = $q->fetch_assoc()){
      $qty = (int)$cart[(int)$p["id"]];
      $price = (float)$p["price"];
      $items[] = ["id"=>$p["id"], "name"=>$p["product_name"], "price"=>$price, "qty"=>$qty, "image"=>$p["image_path"]];
      $subtotal += $price * $qty;
    }
  }
}

if(empty($items)){
  die("No items to order.");
}

$total = $subtotal + $shipping;

// insert order
$ins = $conn->prepare("
  INSERT INTO orders
  (user_id, first_name, last_name, phone, email, address, city, area, postcode, notes, payment_method, bkash_no, bkash_trx, shipping_fee, total_amount)
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");
$ins->bind_param(
  "issssssssssssdd",
  $uid, $first, $last, $phone, $email, $addr, $city, $area, $postc, $notes, $pay, $bkNo, $bkTrx, $shipping, $total
);
$ok = $ins->execute();
if(!$ok) die("Order failed.");

$orderId = $conn->insert_id;

// insert items
$itemIns = $conn->prepare("
  INSERT INTO order_items (order_id, listing_id, product_name, price, qty, image_path)
  VALUES (?,?,?,?,?,?)
");

foreach($items as $it){
  $lid = (int)$it["id"];
  $nm  = $it["name"];
  $pr  = (float)$it["price"];
  $qt  = (int)$it["qty"];
  $img = $it["image"];
  $itemIns->bind_param("iisdis", $orderId, $lid, $nm, $pr, $qt, $img);
  $itemIns->execute();
}

// clear cart if it was cart checkout
if($buyId <= 0){
  unset($_SESSION["cart"]);
}

header("Location: ../html/confirmation.php?order_id=".$orderId);
exit;
?>