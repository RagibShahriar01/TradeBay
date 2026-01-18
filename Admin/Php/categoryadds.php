<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$name = $conn->real_escape_string(trim($_POST["name"] ?? ""));
if($name==""){
  $_SESSION["adm_cat_msg"]="Name required!";
  header("Location: ../html/categories.php"); exit;
}

if($conn->query("INSERT INTO categories(name) VALUES('$name')")){
  $_SESSION["adm_cat_msg"]="Category added!";
} else {
  $_SESSION["adm_cat_msg"]="Error: ".$conn->error;
}
header("Location: ../html/categories.php");
exit;
?>
