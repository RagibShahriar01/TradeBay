<?php
session_start();
include __DIR__ . "/auth_guard.php";
include __DIR__ . "/../db/config.php";

$uid = (int)($_SESSION["user_id"] ?? 0);

function back($msg){
  $_SESSION["tb_profile_msg"] = $msg;
  header("Location: ../html/userdashboard.php");
  exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST"){
  header("Location: ../html/userdashboard.php");
  exit;
}

$name  = trim($_POST["name"] ?? "");
$phone = trim($_POST["phone"] ?? "");

// if user pressed save with empty data
if($name === "" || $phone === ""){
  back("Name and Phone cannot be empty!");
}

$stmt = $conn->prepare("UPDATE users SET name=?, phone=? WHERE id=?");
if(!$stmt){
  back("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssi", $name, $phone, $uid);

if(!$stmt->execute()){
  back("Update failed: " . $stmt->error);
}

// If user saved same values, affected_rows can be 0 (not an error)
if($stmt->affected_rows === 0){
  back("No changes were made (same values).");
}

back("Profile updated successfully!");
