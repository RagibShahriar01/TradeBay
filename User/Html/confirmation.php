<?php
include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];
$orderId = isset($_GET["order_id"]) ? (int)$_GET["order_id"] : 0;

$o = $conn->prepare("SELECT * FROM orders WHERE id=? AND user_id=? LIMIT 1");
$o->bind_param("ii", $orderId, $uid);
$o->execute();
$or = $o->get_result();
if(!$or || $or->num_rows==0) die("Order not found.");
$order = $or->fetch_assoc();

$items = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
$items->bind_param("i", $orderId);
$items->execute();
$itemRows = $items->get_result();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>TradeBay</title>
  <link rel="stylesheet" href="../Css/confirmation.css">
</head>
<body>

<!-- ✅ keep your header same -->


   <div class="logo-container">
            <a href="">
            <span style="color: blue;">T</span>
            <span style="color: green;">r</span>
            <span style="color: red;">a</span>
            <span style="color: blue;">d</span>
            <span style="color: red;">e</span>
            <span style="color: green;">B</span>
            <span style="color: blue;">a</span>
            <span style="color: orange;">y</span>
            </a>
      </div>

<h1 class="checkout-title">Confirmation</h1>

<section class="order-confirmation">
  <p class="thank-you">Thank you. Your order has been received.</p>


  <h2>Order details</h2>

  <table class="order-table">
    <tr><th>Product</th><th>Total</th></tr>

    <?php
      $sub = 0.0;
      while($it = $itemRows->fetch_assoc()){
        $line = (float)$it["price"] * (int)$it["qty"];
        $sub += $line;
    ?>
      <tr>
        <td><strong><?php echo htmlspecialchars($it["product_name"]); ?></strong> * <?php echo (int)$it["qty"]; ?></td>
        <td><?php echo number_format($line,2); ?> taka</td>
      </tr>
    <?php } ?>


    <tr><td>Order Number:</td><td><?php echo (int)$order["id"]; ?></td></tr>
    <tr><td>Subtotal:</td><td><?php echo number_format($sub,2); ?> taka</td></tr>
    <tr><td>Date:</td><td><?php echo htmlspecialchars($order["created_at"]); ?></td></tr>
    <tr><td>Shipping:</td><td><?php echo number_format((float)$order["shipping_fee"],2); ?> taka</td></tr>
    <tr><td>Payment method:</td><td><?php echo htmlspecialchars($order["payment_method"]); ?></td></tr>
    <tr><td><strong>Total:</strong></td><td><strong><?php echo number_format((float)$order["total_amount"],2); ?> taka</strong></td></tr>
  </table>

  <h2>Billing address</h2>
  <div class="billing-box">
    <?php echo htmlspecialchars($order["first_name"]." ".$order["last_name"]); ?><br>
    <?php echo htmlspecialchars($order["address"]); ?><br>
    <?php echo htmlspecialchars($order["city"]); ?><br>
    <?php echo htmlspecialchars($order["area"]); ?><br>
    <?php echo htmlspecialchars($order["postcode"]); ?><br>
    <?php echo htmlspecialchars($order["phone"]); ?><br>
    ✉ <?php echo htmlspecialchars($order["email"]); ?>

    <?php if($order["payment_method"]==="bkash"){ ?>
      <table class="bkash-table">
        <tr><td><strong>bKash No:</strong></td><td><?php echo htmlspecialchars($order["bkash_no"]); ?></td></tr>
        <tr><td><strong>bKash Transaction ID:</strong></td><td><?php echo htmlspecialchars($order["bkash_trx"]); ?></td></tr>
      </table>
    <?php } ?>
  </div>
</section>

<!-- ✅ keep your footer same -->

</body>
</html>
