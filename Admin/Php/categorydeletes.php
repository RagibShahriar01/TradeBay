<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$id = (int)($_POST["id"] ?? 0);
if($id<=0){ header("Location: ../html/categories.php"); exit; }

// prevent delete if listings exist
$cnt = $conn->query("SELECT COUNT(*) AS c FROM listings WHERE category_id=$id")->fetch_assoc();
if((int)$cnt["c"] > 0){
  $_SESSION["adm_cat_msg"]="Can't delete: category is used by listings!";
  header("Location: ../html/categories.php"); exit;
}

$conn->query("DELETE FROM categories WHERE id=$id");
$_SESSION["adm_cat_msg"]="Category deleted!";
header("Location: ../html/categories.php");
exit;
?>
