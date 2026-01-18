<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$aid = (int)$_SESSION["admin_id"];
$id = (int)($_POST["id"] ?? 0);
if($id<=0){ header("Location: ../html/pending.php"); exit; }

if(isset($_POST["approve"])){
  $conn->query("UPDATE listings
                SET status='approved', rejection_reason=NULL, reviewed_at=NOW(), reviewed_by=$aid
                WHERE id=$id AND status='pending'");
  $_SESSION["adm_pending_msg"] = "Approved!";
  header("Location: ../html/pending.php"); exit;
}

if(isset($_POST["reject"])){
  $reason = $conn->real_escape_string(trim($_POST["reason"] ?? "Rejected"));
  if($reason=="") $reason="Rejected";

  $conn->query("UPDATE listings
                SET status='rejected', rejection_reason='$reason', reviewed_at=NOW(), reviewed_by=$aid
                WHERE id=$id AND status='pending'");
  $_SESSION["adm_pending_msg"] = "Rejected!";
  header("Location: ../html/pending.php"); exit;
}

header("Location: ../html/pending.php");
exit;
?>
