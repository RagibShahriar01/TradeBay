<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$rows = $conn->query("
  SELECT oi.*, o.id AS order_id, o.created_at, u.name AS buyer_name, u.email AS buyer_email
  FROM order_items oi
  JOIN orders o ON o.id = oi.order_id
  JOIN users u ON u.id = o.user_id
  ORDER BY o.id DESC, oi.id DESC
");

$msg = $_SESSION["adm_order_msg"] ?? "";
unset($_SESSION["adm_order_msg"]);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Order Items</title>

  <!-- ✅ keep your base checkout style -->
  <link rel="stylesheet" href="../../user/Css/checkout.css">

  <!-- ✅ new page css -->
  <link rel="stylesheet" href="../css/orders.css">
</head>
<body>

<h1 class="checkout-title">Order Items</h1>

<div class="orderitems-wrap">

  <?php if($msg!=""){ ?>
    <p class="order-msg"><?php echo htmlspecialchars($msg); ?></p>
  <?php } ?>

  <div class="order-table-wrap">
    <table class="orderitems-table">
      <tr>
        <th>Order</th>
        <th>Buyer</th>
        <th>Product</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
      </tr>

      <?php if($rows && $rows->num_rows > 0){ ?>
        <?php while($r=$rows->fetch_assoc()){ ?>
          <tr>
            <td>#<?php echo (int)$r["order_id"]; ?></td>

            <td>
              <?php echo htmlspecialchars($r["buyer_name"]); ?><br>
              <?php echo htmlspecialchars($r["buyer_email"]); ?>
            </td>

            <td>
              <?php echo htmlspecialchars($r["product_name"]); ?> * <?php echo (int)$r["qty"]; ?>
            </td>

            <td>
              <?php echo number_format((float)$r["price"]*(int)$r["qty"],2); ?> taka
            </td>

            <td><?php echo htmlspecialchars($r["status"]); ?></td>

            <td>
              <?php if($r["status"] !== "sold"){ ?>
                <form method="post" action="../php/ordersells.php"
                      onsubmit="return confirm('Mark as sold? This will remove listing.');">
                  <input type="hidden" name="order_item_id" value="<?php echo (int)$r["id"]; ?>">
                  <input type="hidden" name="listing_id" value="<?php echo (int)$r["listing_id"]; ?>">
                  <button type="submit" name="sell" class="sell-btn">Sell</button>
                </form>
              <?php } else { ?>
                -
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="empty-row">No orders yet.</td>
        </tr>
      <?php } ?>
    </table>
  </div>

  <p class="back-link"><a href="admindashboard.php">← Back</a></p>
</div>

</body>
</html>
