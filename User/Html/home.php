<?php
session_start();
include "../db/config.php";
$isLoggedIn = isset($_SESSION["user_id"]) && (int)$_SESSION["user_id"] > 0;
$isLoggedIn = isset($_SESSION["user_id"]) && (int)$_SESSION["user_id"] > 0;
$userName = $_SESSION["user_name"] ?? "";


// all approved products
$products = $conn->query("
  SELECT l.id, l.product_name, l.price, l.image_path, l.category_id
  FROM listings l
  WHERE l.status='approved'
  ORDER BY l.created_at DESC
");
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <title>TradeBay</title>
    <link rel="stylesheet" href="../Css/home.css">
</head>
<body>
    <section class="first-section">
        <div class="a-container">
        <div class="first-container">
      <?php if(!$isLoggedIn){ ?>
       Hello, buddy! <a href="login.php">Login</a> or <a href="register.php">Register</a>
      <?php 
      } 
      else { 
        ?>Welcome,<?php echo htmlspecialchars($userName); ?> <?php 
        } 
      ?>


        </div>

        
        <div class="second-container">
        <a href="sell.php">Sell</a>
    </div>
    </div>

    <div class="list-container">
       
       
      <?php if($isLoggedIn){ ?>
          <div class="dropdown">
            <a href="userdashboard.php">My TradeBay</a>
            <a href="../Php/logout.php">Logout</a>
          </div>
        <?php 
        } 
        else { 
          ?>
          <div class="dropdown">
            <a href="login.php">My TradeBay</a>
        </div>
        <?php 
        } ?>




       <div>
         
        <a href="cart.php"><img src="../Images/second.png" alt="Cart"></a>

       </div>
    </div>
    </section>

    <hr>

    <section class="second-section">
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
        

         




        <form class="search-bar" id="searchForm">
  <div class="search-input">
    <span class="search-icon">🔍</span>
    <input type="text" id="searchInput" placeholder="Search products by name...">
  </div>

  
</form>


        




    </section>

    <hr>
    <div class="category-bar">
      <a href="category.php?id=8">Audio</a>
      <a href="category.php?id=9">Battery & Power</a>
      <a href="category.php?id=10">Desktop Accessories</a>
      <a href="category.php?id=12">Gadgets</a>
      <a href="category.php?id=11">Watches</a>
    </div>




    
<section class="all-products">
  <h2 class="all-products-title">All Products</h2><br><br>

 <div class="product-grid" id="productGrid">

    <?php if($products && $products->num_rows > 0){ ?>
      <?php while($p = $products->fetch_assoc()){ ?>
        <a class="product-card" href="product.php?id=<?php echo (int)$p["id"]; ?>">
          <div class="product-img-wrap">
            <img src="../<?php echo htmlspecialchars($p["image_path"]); ?>" alt="">
          </div>
          <div class="product-meta">
            <p class="product-name"><?php echo htmlspecialchars($p["product_name"]); ?></p>
            <p class="product-price"><?php echo number_format((float)$p["price"],2); ?> Taka</p>
          </div>
        </a>
      <?php } ?>
    <?php } else { ?>
      <p style="margin:20px 0;color:gray;">No approved products yet.</p>
    <?php } ?>
  </div>
</section>




<br><br>
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-col">
      <h4>TradeBay LTD.</h4>
      <ul class="footer-list">
        <li>About Us</li>
        <li>Privacy Policy</li>
        <li>Terms Of Use</li>
        <li>Limited Warranty</li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>CUSTOMER CARE</h4>
      <ul class="footer-list">
        <li><a href="#">Contact Us</a></li>
  
        <li><a href="tel:+8801709995757">+8801709995757</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>CUSTOMER INFORMATION</h4>
      <ul class="footer-list">
        <li>Returns & Exchanges</li>
        <li>Shipping Information</li>
        <li>Offers & Promotions</li>
        <li>Size Charts</li>
        <li>Gift Voucher</li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>FOLLOW US!</h4>

      <div class="socials">
        <a href="https://www.instagram.com/"><img src="../Images/instagram.png" alt="Instagram"></a>
        <a href="https://www.facebook.com/"><img src="../Images/facebook.png" alt="Facebook"></a>
        <a href="https://twitter.com/"><img src="../Images/twitter.png" alt="Twitter"></a>
        <a href="https://www.youtube.com/"><img src="../Images/youtube.png" alt="YouTube"></a>
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
      <small>© 2026 <span id="year"></span>TradeBay Ltd. All rights reserved.</small>
    </div>
  </div>
</footer>


<script src="../Js/homesearch.js"></script>

</body>
</html>




