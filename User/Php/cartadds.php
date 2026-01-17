<?php
include "auth_guard.php"; // login required
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$listingId = isset($data["listing_id"]) ? (int)$data["listing_id"] : 0;

if($listingId <= 0){
  echo json_encode(["ok"=>false, "message"=>"Invalid product"]);
  exit;
}

if(!isset($_SESSION["cart"])) $_SESSION["cart"] = [];

if(isset($_SESSION["cart"][$listingId])){
  $_SESSION["cart"][$listingId] += 1;
} else {
  $_SESSION["cart"][$listingId] = 1;
}

echo json_encode(["ok"=>true, "message"=>"Added to cart"]);
