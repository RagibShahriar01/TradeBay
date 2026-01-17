<?php

include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $product_name = $conn->real_escape_string(trim($_POST["product_name"] ?? ""));
    $description  = $conn->real_escape_string(trim($_POST["description"] ?? ""));
    $category_id  = (int)($_POST["category_id"] ?? 0);
    $cond         = $conn->real_escape_string(trim($_POST["item_condition"] ?? ""));
    $location     = $conn->real_escape_string(trim($_POST["location"] ?? ""));
    $price        = (float)($_POST["price"] ?? 0);


    if($product_name=="" || $description=="" || $category_id<=0 || $cond=="" || $location=="" || $price<=0){
        $_SESSION["tb_list_msg"] = "All fields are required!";
        header("Location: ../html/listitem.php"); exit;
    }


    if(!isset($_FILES["photo"]) || $_FILES["photo"]["error"]!=0){
        $_SESSION["tb_list_msg"] = "Image upload failed!";
        header("Location: ../html/listitem.php"); exit;
    }


    $type = $_FILES["photo"]["type"];
    if($type !== "image/png" && $type !== "image/jpeg"){
        $_SESSION["tb_list_msg"] = "Only PNG or JPEG allowed!";
        header("Location: ../html/listitem.php"); exit;
    }


    $ext = ($type==="image/png") ? ".png" : ".jpg";
    $dir = "../Images/listings";
    if(!is_dir($dir)){
        mkdir($dir, 0777, true);
    }


    $fname = "u".$uid."_".time().$ext;
    $path = $dir."/".$fname;


    if(!move_uploaded_file($_FILES["photo"]["tmp_name"], $path)){
        $_SESSION["tb_list_msg"] = "Could not save image!";
        header("Location: ../html/listitem.php"); exit;
    }


    // store relative path from user folder
    $dbPath = "Images/listings/".$fname;

    $sql = "INSERT INTO listings(user_id,category_id,product_name,description,item_condition,location,price,image_path,status)
            VALUES($uid,$category_id,'$product_name','$description','$cond','$location',$price,'$dbPath','pending')";
    
    if($conn->query($sql)){
        $_SESSION["tb_list_msg"] = "Listing submitted! Waiting for admin approval.";
        header("Location: ../html/listitem.php"); exit;
    } 
    
    
    else {
        $_SESSION["tb_list_msg"] = "DB Error: ".$conn->error;
        header("Location: ../html/listitem.php"); exit;
    }
}


header("Location: ../html/listitem.php");
exit;
?>
