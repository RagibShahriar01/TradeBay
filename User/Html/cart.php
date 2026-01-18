<?php
include "../php/auth_guard.php";
include "../db/config.php";

$cart = $_SESSION["cart"] ?? [];   // [listing_id => qty]
$items = [];
$total = 0;

if (!empty($cart)) {
  $ids = array_map("intval", array_keys($cart));
  $idList = implode(",", $ids);

  // only approved products
  $res = $conn->query("
    SELECT id, product_name, price, image_path
    FROM listings
    WHERE status='approved' AND id IN ($idList)
  ");

  if ($res) {
    while ($row = $res->fetch_assoc()) {
      $items[(int)$row["id"]] = $row;
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Cart</title>
  <link rel="stylesheet" href="../Css/home.css">
  <link rel="stylesheet" href="../Css/cart.css">
</head>
<body>

<h1 class="checkout-title">My Cart</h1>

<div class="cart-wrap">

  <?php if (empty($cart)) { ?>
    <p style="margin:20px 0;color:gray;">Your cart is empty.</p>
    <p><a href="home.php">← Continue shopping</a></p>

  <?php } else { ?>

    <div class="sales-table-wrap">
      <table class="sales-table">
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Subtotal</th>
          <th>Remove</th>
        </tr>

        <?php foreach ($cart as $id => $qty) {
          $id = (int)$id;
          $qty = (int)$qty;

          // if product removed/unapproved, skip it
          if (!isset($items[$id])) continue;

          $p = $items[$id];
          $price = (float)$p["price"];
          $sub = $price * $qty;
          $total += $sub;
        ?>
          <tr>
            <td>
              <img class="sales-img" src="../<?php echo htmlspecialchars($p["image_path"]); ?>" alt="">
            </td>

            <td><?php echo htmlspecialchars($p["product_name"]); ?></td>

            <td><?php echo number_format($price, 2); ?> taka</td>

            <td>
             <form method="post" class="qty-form">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input type="hidden" name="qty" value="1">
  <span class="qty-text">1</span>
</form>

            </td>

            <td><?php echo number_format($sub, 2); ?> taka</td>

            <td>
              <form method="post" action="../php/cartremoves.php" onsubmit="return confirm('Remove this item?');">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button class="btn-delete" type="submit">Remove</button>
              </form>
            </td>
          </tr>
        <?php } ?>

        <tr>
          <td colspan="4" style="text-align:right;"><b>Total</b></td>
          <td colspan="2"><b><?php echo number_format($total, 2); ?> taka</b></td>
        </tr>
      </table>
    </div>

    <div class="cart-actions">
      <a class="cart-link" href="home.php">← Continue shopping</a>
      <a class="cart-checkout" href="../Php/checkouts.php">Proceed to Checkout</a>

    </div>

  <?php } ?>

</div>

</body>
</html>
