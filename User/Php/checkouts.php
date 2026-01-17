<?php
include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];
$shipping = 60.00;

$buyId = isset($_GET["buy_id"]) ? (int)$_GET["buy_id"] : 0;

// user autofill
$u = $conn->query("SELECT name,email,phone FROM users WHERE id=$uid LIMIT 1");
$user = ($u && $u->num_rows>0) ? $u->fetch_assoc() : ["name"=>"","email"=>"","phone"=>""];

$items = [];
$subtotal = 0.00;

if ($buyId > 0) {
  $st = $conn->prepare("SELECT id, product_name, price, image_path FROM listings WHERE id=? AND status='approved' LIMIT 1");
  $st->bind_param("i", $buyId);
  $st->execute();
  $r = $st->get_result();
  if ($r && $r->num_rows > 0) {
    $p = $r->fetch_assoc();
    $items[] = ["id"=>(int)$p["id"], "name"=>$p["product_name"], "price"=>(float)$p["price"], "qty"=>1, "image"=>$p["image_path"]];
    $subtotal += (float)$p["price"];
  }
} else {
  $cart = $_SESSION["cart"] ?? [];
  if (!empty($cart)) {
    $ids = array_map("intval", array_keys($cart));
    $in = implode(",", $ids);
    if ($in !== "") {
      $q = $conn->query("SELECT id, product_name, price, image_path FROM listings WHERE status='approved' AND id IN ($in)");
      while ($p = $q->fetch_assoc()) {
        $pid = (int)$p["id"];
        $qty = (int)$cart[$pid];
        $price = (float)$p["price"];
        $items[] = ["id"=>$pid, "name"=>$p["product_name"], "price"=>$price, "qty"=>$qty, "image"=>$p["image_path"]];
        $subtotal += $price * $qty;
      }
    }
  }
}

$total = $subtotal + $shipping;

$full = trim($user["name"]);
$parts = preg_split("/\s+/", $full);
$firstName = $parts[0] ?? "";
$lastName  = (count($parts) > 1) ? end($parts) : "";

// ✅ load the template (HTML file)
include "../Html/checkout.php";
?>