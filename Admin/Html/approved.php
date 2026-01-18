<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$rows = $conn->query("SELECT l.*, c.name AS cat_name, u.name AS seller_name
                      FROM listings l
                      JOIN categories c ON c.id=l.category_id
                      JOIN users u ON u.id=l.user_id
                      WHERE l.status='approved'
                      ORDER BY l.created_at DESC");

$msg = $_SESSION["adm_app_msg"] ?? "";
unset($_SESSION["adm_app_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Approved Products</title>
  <link rel="stylesheet" href="../../user/Css/checkout.css">
  <link rel="stylesheet" href="../css/approved.css">
</head>
<body>

<h1 class="checkout-title">Approved products</h1>

<div class="approved-wrap">

  <?php if($msg != ""){ ?>
    <p class="sales-msg"><?php echo htmlspecialchars($msg); ?></p>
  <?php } ?>

  <div class="sales-table-wrap">
    <table class="sales-table">
      <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Category</th>
        <th>Price</th>
        <th>Seller</th>
        <th>Action</th>
      </tr>

      <?php if($rows && $rows->num_rows > 0){ ?>
        <?php while($r=$rows->fetch_assoc()){ ?>
          <tr>
            <td>
              <img class="sales-img" src="../../user/<?php echo $r["image_path"]; ?>" alt="Product">
            </td>

            <td><?php echo htmlspecialchars($r["product_name"]); ?></td>
            <td><?php echo htmlspecialchars($r["cat_name"]); ?></td>
            <td><?php echo number_format((float)$r["price"],2); ?> taka</td>
            <td><?php echo htmlspecialchars($r["seller_name"]); ?></td>

            <td>
              <form method="post" action="../php/productdeletes.php"
                    onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="id" value="<?php echo (int)$r["id"]; ?>">
                <button type="submit" name="delete" class="btn-delete">Delete</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="sales-empty">No approved products found.</td>
        </tr>
      <?php } ?>
    </table>
  </div>

  <p class="back-row"><a href="admindashboard.php">← Back</a></p>

</div>


</body>
</html>
