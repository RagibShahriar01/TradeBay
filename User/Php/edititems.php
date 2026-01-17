<?php
include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $id = (int)($_POST["id"] ?? 0);

  $q = $conn->query("SELECT * FROM listings WHERE id=$id AND user_id=$uid LIMIT 1");
  if(!$q || $q->num_rows==0){ header("Location: ../html/saleshistory.php"); exit; }
  $item = $q->fetch_assoc();

  if($item["status"]==="approved"){
    $_SESSION["tb_edit_msg"] = "Approved items cannot be edited!";
    header("Location: ../html/saleshistory.php"); exit;
  }

  $product_name = $conn->real_escape_string(trim($_POST["product_name"] ?? ""));
  $description  = $conn->real_escape_string(trim($_POST["description"] ?? ""));
  $category_id  = (int)($_POST["category_id"] ?? 0);
  $cond         = $conn->real_escape_string(trim($_POST["item_condition"] ?? ""));
  $location     = $conn->real_escape_string(trim($_POST["location"] ?? ""));
  $price        = (float)($_POST["price"] ?? 0);

  if($product_name=="" || $description=="" || $category_id<=0 || $cond=="" || $location=="" || $price<=0){
    $_SESSION["tb_edit_msg"] = "All fields are required!";
    header("Location: ../html/edititem.php?id=".$id); exit;
  }

  $dbPath = $item["image_path"];

  // optional photo change
  if(isset($_FILES["photo"]) && $_FILES["photo"]["error"]==0){
    $type = $_FILES["photo"]["type"];
    if($type !== "image/png" && $type !== "image/jpeg"){
      $_SESSION["tb_edit_msg"] = "Only PNG or JPEG allowed!";
      header("Location: ../html/edititem.php?id=".$id); exit;
    }

    $ext = ($type==="image/png") ? ".png" : ".jpg";
    $dir = "../Images/listings";
    if(!is_dir($dir)){ mkdir($dir, 0777, true); }

    $fname = "u".$uid."_".time().$ext;
    $path = $dir."/".$fname;

    if(move_uploaded_file($_FILES["photo"]["tmp_name"], $path)){
      $dbPath = "Images/listings/".$fname;
    }
  }

  $sql = "UPDATE listings SET
            category_id=$category_id,
            product_name='$product_name',
            description='$description',
            item_condition='$cond',
            location='$location',
            price=$price,
            image_path='$dbPath',
            status='pending',
            rejection_reason=NULL,
            reviewed_at=NULL,
            reviewed_by=NULL
          WHERE id=$id AND user_id=$uid";

  if($conn->query($sql)){
    $_SESSION["tb_list_msg"] = "Updated! Sent again for admin approval.";
    header("Location: ../html/saleshistory.php"); exit;
  } else {
    $_SESSION["tb_edit_msg"] = "DB Error: ".$conn->error;
    header("Location: ../html/edititem.php?id=".$id); exit;
  }
}

header("Location: ../html/saleshistory.php");
exit;
?>
