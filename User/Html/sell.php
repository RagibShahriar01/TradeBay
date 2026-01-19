<?php include "../php/auth_guard.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>TradeBay</title>
    <link rel="stylesheet" href="../Css/sell.css">

</head>
<body>
    

      

   

    <section class="second-section">
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
         <form class="search-bar">
        
    </form>
    </section>
<hr>
   <section class="selling-section">
    <div class="selling">
        Selling
    </div>
    <div class="category-bar">

        <a href="listitem.php" style="text-decoration:none;">
        <button type="button" class="search-btn">List an item</button>
        </a>

    </div>
</section>

<section class="sell-section">
    <div class="sell-left">
        <h1>If you don’t love it,<br>list it</h1>
        <p>
            Cash in on your pre-loved pieces – millions of<br>
            buyers are waiting.
        </p>

       <a href="listitem.php" style="text-decoration:none;">
       <button type="button" class="sell-btn">Sell now</button>
       </a>

    </div>

    <div class="sell-right">
        <img src="../Images/shoe1.jpeg" alt="">
        <img src="../Images/shoe2.jpeg" alt="">
        <img src="../Images/watch.jpeg" alt="">
    </div>
</section>

<section class="sell-info">
    <h1 class="sell-title">Reach millions of trusted buyers on TradeBay</h1>

    <div class="sell-features">
        <div class="feature">
            <h2>Quick listing</h2>
            <p>
                List in a few steps with AI-powered help for pricing and descriptions.
                Only pay a final value fee when your item sells.
            </p>
        </div>

        <div class="feature">
            <h2>Secure Payments</h2>
            <p>
                Get paid securely with fraud detection, dispute resolution,
                and safeguards against abusive buyers.
            </p>
        </div>

        <div class="feature">
            <h2>Easy shipping</h2>
            <p>
                Pick your carrier or use our suggestions—get discounted shipping
                labels on TradeBay, or arrange a local pickup directly with the buyer.
            </p>
        </div>
    </div>
</section>
 
  <section class="business-sell">
    <div class="business-left">
        <h1>Selling as a business? We<br>make it easy</h1>

        <p>
            We’ve got powerful tools to help you manage your inventory and orders,
            track your sales, and build your brand.
        </p>

    </div>

    <div class="business-right">
        <img src="../Images/business-selling.png" alt="">
    </div>
</section>

<!-- card-scroll -->
<section class="listing-tips">
    <h1>Create a great listing</h1>
    <p class="subtitle">Here’s six ways to set yourself up for success.</p>

    <div class="card-scroll">
        <div class="tip-card card-1">
            <h2>Write a standout title</h2>
            <ul>
                <li>We’ll recommend search terms buyers often use.</li>
                <li>Avoid all caps. Focus on brand, model, size, and color.</li>
            </ul>
        </div>

        <div class="tip-card card-2">
            <h2>Take high-quality photos</h2>
            <ul>
                <li>Take photos from multiple angles in good lighting.</li>
                <li>Use a clean background and show any flaws.</li>
            </ul>
        </div>

        <div class="tip-card card-3">
            <h2>Pick a purchase format</h2>
            <ul>
                <li>Buy It Now if you want to sell quickly.</li>
                <li>Use Auction if you want the best price.</li>
            </ul>
        </div>

        <div class="tip-card card-4">
            <h2>Set the right price</h2>
            <ul>
                <li>Check similar sold items before pricing.</li>
                <li>Consider offers to attract buyers.</li>
            </ul>
        </div>

        <div class="tip-card card-5">
            <h2>Offer great shipping</h2>
            <ul>
                <li>Provide fast and affordable shipping options.</li>
                <li>Use TradeBay labels to save money.</li>
            </ul>
        </div>

        <div class="tip-card card-6">
            <h2>Build buyer trust</h2>
            <ul>
                <li>Add clear descriptions and return policies.</li>
                <li>Respond quickly to buyer questions.</li>
            </ul>
        </div>
    </div>
</section>

<!-- footer image -->
 <section class="footer-hero">
  <div class="footer-hero-bg">
    <img src="../Images/woman.jpeg" alt="Selling banner">
  </div>

  <div class="footer-card">
    <h2>You’ve got this.<br>We’ve got your back.</h2>

    <a href="listitem.php" style="text-decoration:none;">
    <button type="button" class="footer-btn">List an item</button>
    </a>

  </div>
</section>

<hr>

<footer>
  
  <div class="footer-bottom">
    <div class="footer-inner">
      <small>© 2026 <span id="year"></span>TradeBay Ltd. All rights reserved.</small><br><br>
    </div>
  </div>
</footer>
</body>
</html>
