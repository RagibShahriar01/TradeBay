<!DOCTYPE html>
<html lang="en">
<head>
  <title>TradeBay</title>
  <link rel="stylesheet" href="../Css/checkout.css">
</head>
<body>

<!-- ✅ keep your header same -->

   <div class="logo-container">
            <a href="http://localhost/TradeBay/User/Html/home.php">
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

<h1 class="checkout-title">Checkout</h1>

<form method="post" action="../php/orderplaces.php<?php echo $buyId>0 ? "?buy_id=".$buyId : ""; ?>">
<section class="checkout-wrapper">

  <div class="checkout-left">
    <h2>Billing Details</h2>
    <br><br>

    <div class="row">
      <input type="text" name="first_name" placeholder="First Name *"
             value="<?php echo htmlspecialchars($firstName); ?>" required>

      <input type="text" name="last_name" placeholder="Last Name *"
             value="<?php echo htmlspecialchars($lastName); ?>" required>
    </div>

    <input type="text" name="phone" placeholder="Phone *"
           value="<?php echo htmlspecialchars($user["phone"]); ?>" required>

    <input type="email" name="email" placeholder="Email Address *"
           value="<?php echo htmlspecialchars($user["email"]); ?>" required>

    <input type="text" name="address" placeholder="Full shipping address *" required>

    <div class="row">
      <input type="text" name="city" placeholder="City *" required>
      <select name="area" required>
        <option value="">Select</option>
        <option value="Dhaka">Dhaka</option>
        <option value="Chattogram">Chattogram</option>
      </select>
    </div>

    <input type="text" name="postcode" placeholder="Postcode (optional)">
    <textarea name="notes" placeholder="Order notes (optional)"></textarea>
  </div>

  <div class="checkout-right">

    <div class="box">
      <h2>Your Order</h2>

      <?php if(empty($items)){ ?>
        <div class="order-row">
          <span>No items to checkout.</span>
          <strong>0 taka</strong>
        </div>
      <?php } else { ?>
        <?php foreach($items as $it){ ?>
          <div class="order-row">
            <span><?php echo htmlspecialchars($it["name"]); ?> * <?php echo (int)$it["qty"]; ?></span>
            <strong><?php echo number_format($it["price"]*$it["qty"],2); ?> taka</strong>
          </div>
        <?php } ?>
      <?php } ?>

      <div class="order-row">
        <span>Shipping</span>
        <strong><?php echo number_format($shipping,2); ?> taka</strong>
      </div>

      <hr>

      <div class="order-row total">
        <span>Total</span>
        <strong><?php echo number_format($total,2); ?> taka</strong>
      </div>
    </div>

    <div class="box">
      <h2>Payment Method</h2>

      <label class="payment-option">
        <input type="radio" name="payment_method" value="bkash" required>
        <span>bKash</span>
      </label>

      <label class="payment-option">
        <input type="radio" name="payment_method" value="cod" required>
        <span>Cash on Delivery</span>
      </label>

      <div class="box">
        <div class="bkash-box">
          <p class="bkash-text">
            Pay with bKash Personal Number <strong>01764288347</strong>
            and enter your payment details below.
          </p>

          <input type="text" name="bkash_no" placeholder="bKash Number">
          <input type="text" name="bkash_trx" placeholder="bKash Transaction ID">
        </div>
      </div>

      <button class="place-order" type="submit" name="place_order">Place Order</button>
    </div>

  </div>

</section>
</form>

<!-- ✅ keep your footer same -->

</body>
</html>
