<?php
include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];
$id = (int)($_GET["id"] ?? 0);

$q = $conn->query("SELECT * FROM listings WHERE id=$id AND user_id=$uid LIMIT 1");
if(!$q || $q->num_rows==0){ header("Location: saleshistory.php"); exit; }
$item = $q->fetch_assoc();

$cats = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");

$msg = $_SESSION["tb_edit_msg"] ?? "";
unset($_SESSION["tb_edit_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Item</title>
  <link rel="stylesheet" href="../Css/edititem.css">
</head>
<body>

<h1 class="checkout-title">Edit Listing</h1>

<section class="checkout-wrapper">
  <div class="checkout-left">

    <p class="msg"><?php echo $msg; ?></p>

    <form method="post" action="../php/edititems.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $item["id"]; ?>">

      <label><b>Current photo</b></label><br><br>

      <img class="current-photo" src="../<?php echo $item["image_path"]; ?>" alt="Current Photo">

      <br><br>

      <label><b>Change photo (optional PNG/JPEG)</b></label>
      <input type="file" name="photo" accept="image/png,image/jpeg">

      <label><b>Product name</b></label>
      <input type="text" name="product_name" value="<?php echo htmlspecialchars($item["product_name"]); ?>" required>

      <label><b>Description</b></label>
      <textarea name="description" required><?php echo htmlspecialchars($item["description"]); ?></textarea>

      <label><b>Category</b></label>
      <select name="category_id" required>
        <?php while($c=$cats->fetch_assoc()){ ?>
          <option value="<?php echo $c["id"]; ?>" <?php if($c["id"]==$item["category_id"]) echo "selected"; ?>>
            <?php echo htmlspecialchars($c["name"]); ?>
          </option>
        <?php } ?>
      </select>

      <label><b>Condition</b></label>
      <select name="item_condition" required>
        <?php
          $conds = ["New","Never worn","Gently used","Used","Very worn"];
          foreach($conds as $cc){
            $sel = ($cc==$item["item_condition"]) ? "selected" : "";
            echo "<option $sel>$cc</option>";
          }
        ?>
      </select>

      <label><b>Location</b></label>
      <input type="text" name="location" value="<?php echo htmlspecialchars($item["location"]); ?>" required>

      <label><b>Price</b></label>
      <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($item["price"]); ?>" required>

      <button class="place-order" type="submit" name="update">Update & Send for approval</button>
    </form>

  </div>

  <div class="checkout-right">
    <h2>Note</h2>
    <p class="note-text">After update, this listing will go back to <b>pending</b> for admin review.</p>
    <a class="back-link" href="saleshistory.php">Back</a>
  </div>
</section>

</body>
</html>
