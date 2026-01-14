<!DOCTYPE html>
<html lang="en">
<head>

    <title>TradeBay</title>
    <link rel="stylesheet" href="../Css/checkout.css">
</head>
<body>
    <section class="first-section">
        <div class="a-container">
        <div class="first-container">
        Hi buddy! <a href="">Login</a> or <a href="">Register</a>
        </div>

        <div class="second-container">
            
            <a href="">Help & Contact</a>
        </div>
        <div class="second-container">
        <a href="">Sell</a>
    </div>
    </div>

    <div class="list-container">
        <div>
        <select class="dropdown">
            <option>Watchlist</option>
        </select>
       </div>
       <div>
        <select class="dropdown">
            <option>My TradeBay</option>
        </select>
       </div>
       <div>
         <a href="">
            <img src="../Images/first.png" alt="">
        </a>
        <a href="">
            <img src="../Images/second.png" alt="">
        </a>
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

    <h1 class="checkout-title">Checkout</h1>

<section class="checkout-wrapper">

  <!-- LEFT : Billing -->
  <div class="checkout-left">
    <h2>Billing Details</h2>

    <br><br>

    <div class="row">
      <input type="text" placeholder="First Name *">
      <input type="text" placeholder="Last Name *">
    </div>

    <input type="text" placeholder="Phone *">
    <input type="email" placeholder="Email Address *">
    <input type="text" placeholder="Full shipping address *">

    <div class="row">
      <input type="text" placeholder="City *">
      <select>
        <option>Dhaka</option>
        <option>Chattogram</option>
      </select>
    </div>

    <input type="text" placeholder="Postcode (optional)">

    <textarea placeholder="Order notes (optional)"></textarea>
  </div>

  <!-- RIGHT : Order + Payment -->
  <div class="checkout-right">

    <!-- Order Summary -->
    <div class="box">
      <h2>Your Order</h2>

      <div class="order-row">
        <span>Mijia Desk Lamp 2 Lite * 1</span>
        <strong>2,950taka</strong>
      </div>

      <div class="order-row">
        <span>Shipping</span>
        <strong>60taka</strong>
      </div>

      <hr>

      <div class="order-row total">
        <span>Total</span>
        <strong>3,010taka</strong>
      </div>
    </div>

    <!-- Payment Method -->
    <div class="box">
      <h2>Payment Method</h2>

      <label class="payment-option">
        <input type="radio" name="payment" checked>
        <span>bKash</span>
      </label>

      <label class="payment-option">
        <input type="radio" name="payment">
        <span>Cash on Delivery</span>
      </label>

      <div class="box">

  <!-- bKash Details -->
  <div class="bkash-box">

    <p class="bkash-text">
      Pay with bKash Personal Number <strong>01XXXXXXXXX</strong>  
      and enter your payment details below.
    </p>

    <input type="text" placeholder="bKash Number">
    <input type="text" placeholder="bKash Transaction ID">

   </div>

  </div>


      <button class="place-order">Place Order</button>
    </div>

  </div>

</section>

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
      <small>© 2026 <span id="year"></span>TradeBay Ltd. All rights reserved.</small>
    </div>
  </div>
</footer>

</body>
</html>
