<?php
include "../php/auth_guard.php";
include "../db/config.php";

$cats = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");
$msg = $_SESSION["tb_list_msg"] ?? "";
unset($_SESSION["tb_list_msg"]);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Sell an item</title>
  <link rel="stylesheet" href="../Css/listitem.css">
</head>
<body>

<h1 class="checkout-title">Sell an item</h1>

<section class="checkout-wrapper">
  <div class="checkout-left">
    <h2>Upload product information</h2>
    <p class="msg"><?php echo $msg; ?></p>

    <form method="post" action="../php/listitems.php" enctype="multipart/form-data">

      <label><b>Product Photo (PNG/JPEG)</b></label><br><br>

      <img id="preview" src="" alt="Preview">

      <input type="file" name="photo" id="photo" accept="image/png,image/jpeg" required>

      <br><br>

      <label><b>Product name</b></label>
      <input type="text" name="product_name" required>

      <label><b>Describe your item</b></label>
      <textarea name="description" required></textarea>

      <label><b>Category</b></label>
      <select name="category_id" required>
        <?php while($c=$cats->fetch_assoc()){ ?>
          <option value="<?php echo $c["id"]; ?>"><?php echo htmlspecialchars($c["name"]); ?></option>
        <?php } ?>
      </select>

      <label><b>Product condition</b></label>
      <select name="item_condition" required>
        <option>New</option>
        <option>Never worn</option>
        <option>Gently used</option>
        <option>Used</option>
        <option>Very worn</option>
      </select>

      <label><b>Location</b></label>
      <input type="text" name="location" required>

      <label><b>Asking Price</b></label>
      <input type="number" name="price" step="0.01" required>

      <button class="place-order" type="submit" name="upload">Upload (Send for approval)</button>
    </form>
  </div>

  <div class="checkout-right">
    <h2>Note</h2>
    <p class="note-text">
      Your listing will be <b>pending</b> until an admin approves it.
    </p>
   
  </div>
</section>

<script src="../Js/listitem.js"></script>

</body>
</html>
