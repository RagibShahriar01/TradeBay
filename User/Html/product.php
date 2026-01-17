<?php
session_start();
include "../db/config.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

$stmt = $conn->prepare("
  SELECT l.*, c.name AS cat_name
  FROM listings l
  JOIN categories c ON c.id=l.category_id
  WHERE l.id=? AND l.status='approved'
  LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if(!$res || $res->num_rows == 0){
  die("Product not found");
}
$p = $res->fetch_assoc();

$isLogged = isset($_SESSION["user_id"]);
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo htmlspecialchars($p["product_name"]); ?> | TradeBay</title>
  <link rel="stylesheet" href="../Css/home.css">
  <link rel="stylesheet" href="../Css/product.css">
</head>
<body>

<!-- ================= HEADER (same structure like your home.php) ================= -->

<section class="first-section">
  <div class="a-container">
    <div class="first-container">
      <?php if(!$isLogged){ ?>
        Hi buddy! <a href="login.php">Login</a> or <a href="register.php">Register</a>
      <?php } else { ?>
        Hi buddy!
      <?php } ?>
    </div>

    <div class="second-container">
      <a href="">Help & Contact</a>
    </div>

    <div class="second-container">
      <a href="sell.php">Sell</a>
    </div>
  </div>

  <div class="list-container">
    <div>
      <select class="dropdown">
        <option>Watchlist</option>
      </select>
    </div>

    <div class="dropdown">
      <?php if($isLogged){ ?>
        <a href="userdashboard.php">My TradeBay</a>
        <a href="../Php/logout.php">Logout</a>
      <?php } else { ?>
        <a href="login.php">My TradeBay</a>
      <?php } ?>
    </div>

    <div>
      <a href=""><img src="../Images/first.png" alt=""></a>
      <a href=""><img src="../Images/second.png" alt=""></a>
    </div>
  </div>
</section>

<hr>

<section class="second-section">
  <div class="logo-container">
    <a href="home.php">
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

  <form class="search-bar">
    <div class="search-input">
      <span class="search-icon">🔍</span>
      <input type="text" placeholder="Search for anything">
    </div>

    <select class="search-category">
      <option>All Categories</option>
      <option>Electronics</option>
      <option>Fashion</option>
      <option>Books</option>
    </select>

    <button type="submit" class="search-btn">Search</button>
  </form>
</section>

<hr>

<div class="category-bar">
  <a href="">Electronic</a>
  <a href="">Motors</a>
  <a href="">Fashion</a>
  <a href="">Collectibles & Art</a>
  <a href="">Sports</a>
  <a href="">Healthy & Beauty</a>
  <a href="">Industrial equipment</a>
  <a href="">Home & Garden</a>
</div>

<!-- ================= PRODUCT CONTENT ================= -->

<div class="product-page">
  <div class="product-left">
    <img class="product-img"
         src="../<?php echo htmlspecialchars($p["image_path"]); ?>"
         alt="">
  </div>

  <div class="product-right">
    <h2 class="product-title"><?php echo htmlspecialchars($p["product_name"]); ?></h2>

    <p class="product-cat">Category: <?php echo htmlspecialchars($p["cat_name"]); ?></p>

    <p class="product-price">
      <?php echo number_format((float)$p["price"],2); ?> taka
    </p>
    
    <p class="product-desc">
      <?php echo nl2br(htmlspecialchars($p["description"] ?? "")); ?>
    </p>
    <br>
    <button id="addToCartBtn"
            data-id="<?php echo (int)$p["id"]; ?>"
            class="search-btn product-btn">
      Add to Cart
    </button>

    <a class="buy-link" href="../Php/checkouts.php?buy_id=<?php echo (int)$p["id"]; ?>">

      <button class="search-btn product-btn buy-now-btn" type="button">
        Buy Now
      </button>
    </a>

    <p id="cartMsg" class="cart-msg"></p>
  </div>
</div>

<!-- ================= FOOTER (same as your home footer) ================= -->

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-col">
      <h4>TradeBay LTD.</h4>
      <ul class="footer-list">
        <li><a href="#">About Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms Of Use</a></li>
        <li><a href="#">Limited Warranty</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>CUSTOMER CARE</h4>
      <ul class="footer-list">
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Purchase Process</a></li>
        <li><a href="tel:+8801709995757">+8801709995757</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>CUSTOMER INFORMATION</h4>
      <ul class="footer-list">
        <li><a href="#">Returns & Exchanges</a></li>
        <li><a href="#">Shipping Information</a></li>
        <li><a href="#">Offers & Promotions</a></li>
        <li><a href="#">Size Charts</a></li>
        <li><a href="#">Gift Voucher</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>FOLLOW US!</h4>

      <div class="socials">
        <a href="#"><img src="../Images/instagram.png" alt="Instagram"></a>
        <a href="#"><img src="../Images/facebook.png" alt="Facebook"></a>
        <a href="#"><img src="../Images/twitter.png" alt="Twitter"></a>
        <a href="#"><img src="../Images/youtube.png" alt="YouTube"></a>
      </div>

      <div class="small-ctas">
        <p class="small-cta">SIGN UP FOR SMS</p>
        <p class="small-cta">FIND OUR SHOP</p>
      </div>

      <div class="payments">
        <img src="../Images/bkash.png" alt="bKash">
        <img src="../Images/rocket.png" alt="Rocket">
        <img src="../Images/nagad.png" alt="Nagad">
        <img src="../Images/visa.png" alt="Visa">
        <img src="../Images/mastercard.png" alt="Mastercard">
        <img src="../Images/amex.png" alt="Amex">
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-inner">
      <small>© 2026 TradeBay Ltd. All rights reserved.</small>
    </div>
  </div>
</footer>

<script src="../Js/cart.js"></script>
</body>
</html>
