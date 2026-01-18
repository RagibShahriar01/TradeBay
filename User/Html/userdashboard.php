<?php
include "../php/auth_guard.php";
include "../db/config.php";

$uid = (int)$_SESSION["user_id"];

// fetch user info (for Account Information tab)
$u = $conn->query("SELECT name,email,phone,gender FROM users WHERE id=$uid LIMIT 1");
$user = ($u && $u->num_rows > 0) ? $u->fetch_assoc() : ["name"=>"", "email"=>"", "phone"=>"", "gender"=>""];

// fetch sales history rows (for Sales History tab)
$salesRows = $conn->query("SELECT l.*, c.name AS cat_name
                           FROM listings l
                           JOIN categories c ON c.id = l.category_id
                           WHERE l.user_id = $uid
                           ORDER BY l.created_at DESC");

$salesMsg = $_SESSION["tb_list_msg"] ?? "";
unset($_SESSION["tb_list_msg"]);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeBay | User Dashboard</title>
    <link rel="stylesheet" href="../Css/userdashboard.css">
</head>
<body>

<section class="first-section">
    <div class="a-container">
        <div class="first-container">
            Hi buddy!
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
        <div>
            <select class="dropdown">
                <option>My TradeBay</option>
            </select>
        </div>
        <div>
            <a href=""><img src="../Images/first.png" alt="Notifications"></a>
            <a href=""><img src="../Images/second.png" alt="Cart"></a>
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

<div class="dashboard">

    <div class="dashboard-sidebar">
        <h3>MY ACCOUNT</h3>
        <button class="tab-btn active" data-target="account">Account Information</button>
        <button class="tab-btn" data-target="orders">Order History</button>
        <button class="tab-btn" data-target="sales">Sales History</button>
    </div>

    <div class="dashboard-content">

        <!-- ================= ACCOUNT TAB ================= -->
        <div class="tab-content active" id="account">

          <form method="post" action="../php/updateprofiles.php" class="account-form" id="accountForm">
            <h2 class="account-header">
              Account Information
              <button type="button" id="editAccountBtn" class="edit-btn">Edit</button>
              <button type="submit" id="saveAccountBtn" class="edit-btn save-hidden" name="save_profile">Save</button>
            </h2>

            <?php if(isset($_SESSION["tb_profile_msg"])) { ?>
              <p class="profile-msg"><?php echo htmlspecialchars($_SESSION["tb_profile_msg"]); ?></p>
              <?php unset($_SESSION["tb_profile_msg"]); ?>
            <?php } ?>

            <div class="info-grid">

              <!-- ✅ Editable -->
              <div class="info-item">
                <label>Your Name</label>
                <input id="nameInput" type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" disabled>
              </div>

              <!-- ❌ Fixed -->
              <div class="info-item">
                <label>Email Address</label>
                <input id="emailInput" type="email" value="<?php echo htmlspecialchars($user["email"]); ?>" disabled>
              </div>

              <!-- ✅ Editable -->
              <div class="info-item">
                <label>Mobile Number</label>
                <input id="phoneInput" type="text" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>" disabled>
              </div>

              <!-- ❌ Fixed -->
              <div class="info-item">
                <label>Gender</label>
                <input id="genderInput" type="text" value="<?php echo htmlspecialchars($user["gender"]); ?>" disabled>
              </div>

            </div>
          </form>
          

        </div>

       
       <!-- ================= ORDERS TAB (CONNECTED TO DB) ================= -->
<?php
$orders = $conn->query("
  SELECT oi.*, o.id AS order_id, o.created_at, o.status AS order_status
  FROM order_items oi
  JOIN orders o ON o.id = oi.order_id
  WHERE o.user_id = $uid
  ORDER BY o.id DESC, oi.id DESC
");
?>

<div class="tab-content" id="orders">
  <h2>Order History</h2>

  <div class="sales-table-wrap">
    <table class="sales-table">
      <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Order</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
      </tr>

      <?php if($orders && $orders->num_rows > 0){ ?>
        <?php while($r = $orders->fetch_assoc()){ ?>
          <tr>
            <td>
              <img class="sales-img" src="../<?php echo htmlspecialchars($r["image_path"]); ?>" alt="">
            </td>
            <td><?php echo htmlspecialchars($r["product_name"]); ?> * <?php echo (int)$r["qty"]; ?></td>
            <td>#<?php echo (int)$r["order_id"]; ?></td>
            <td><?php echo htmlspecialchars($r["created_at"]); ?></td>
            <td><?php echo htmlspecialchars($r["status"]); ?></td>
            <td><?php echo number_format((float)$r["price"]*(int)$r["qty"], 2); ?> taka</td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="sales-empty">No orders yet.</td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div>




        


        

        <!-- ================= SALES TAB (CONNECTED TO DB) ================= -->
        <div class="tab-content" id="sales">
            <h2>Sales History</h2>

            <?php if($salesMsg != ""){ ?>
              <p class="sales-msg"><?php echo htmlspecialchars($salesMsg); ?></p>
            <?php } ?>

            <div class="sales-table-wrap">
              <table class="sales-table">
                  <tr>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>

                  <?php if($salesRows && $salesRows->num_rows > 0){ ?>
                      <?php while($r = $salesRows->fetch_assoc()){ ?>
                          <tr>
                              <td>
                                  <img class="sales-img" src="../<?php echo $r["image_path"]; ?>" alt="">
                              </td>

                              <td><?php echo htmlspecialchars($r["product_name"]); ?></td>
                              <td><?php echo htmlspecialchars($r["cat_name"]); ?></td>
                              <td><?php echo number_format((float)$r["price"], 2); ?> taka</td>

                              <td>
                                  <?php echo htmlspecialchars($r["status"]); ?>

                                  <?php if($r["status"]==="rejected" && !empty($r["rejection_reason"])){ ?>
                                      <div class="reject-reason">
                                          Reason: <?php echo htmlspecialchars($r["rejection_reason"]); ?>
                                      </div>
                                  <?php } ?>
                              </td>

                              <td>
                                  <?php if($r["status"] !== "approved"){ ?>
                                      <a class="edit-link" href="edititem.php?id=<?php echo (int)$r["id"]; ?>">Edit</a>
                                  <?php } else { ?>
                                      -
                                  <?php } ?>
                              </td>
                          </tr>
                      <?php } ?>
                  <?php } else { ?>
                      <tr>
                          <td colspan="6" class="sales-empty">You haven't sold any products yet.</td>
                      </tr>
                  <?php } ?>
              </table>
            </div>

            <p class="list-another">
                <a href="listitem.php">+ List another item</a>
            </p>
        </div>

    </div>
</div>

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

<script src="../Js/userdashboard.js"></script>
</body>
</html>
