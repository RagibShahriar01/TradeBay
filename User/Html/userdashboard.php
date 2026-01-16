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
            <a href=""><img src="../Images/first.png" alt="Notifications"></a>
            <a href=""><img src="../Images/second.png" alt="Cart"></a>
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

<div class="dashboard">

    <div class="dashboard-sidebar">
        <h3>MY ACCOUNT</h3>
        <button class="tab-btn active" data-target="account">Account Information</button>
        <button class="tab-btn" data-target="orders">Order History</button>
        <button class="tab-btn" data-target="sales">Sales History</button>
    </div>

    <div class="dashboard-content">

        <div class="tab-content active" id="account">
           <h2 class="account-header">
    Account Information
    <button type="button" id="editAccountBtn" class="edit-btn">Edit</button>
    </h2>

            
            <div class="info-grid">
                <div class="info-item">
                    <label>Your Name</label>
                    <input type="text" value="" disabled>
                </div>

                <div class="info-item">
                    <label>Email Address</label>
                    <input type="email" value="" disabled>
                </div>

                <div class="info-item">
                    <label>Mobile Number</label>
                    <input type="text" value="" disabled>
                </div>

                <div class="info-item">
                    <label>Gender</label>
                    <select disabled>
                        <option>Select</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>

            <div class="change-password">
                <button type="button" class="change-btn" id="showPasswordForm">
         Change Password
          </button>

                <div class="password-form" id="passwordForm">
                    <input type="password" placeholder="Current Password">
                    <input type="password" placeholder="New Password">
                    <input type="password" placeholder="Confirm New Password">

                    <div class="btn-group">

         <button type="submit" name="save" class="save-btn">
          Save Changes
        </button>

    <button type="button" class="cancel-btn" id="cancelPassword">
        Cancel
    </button>
</div>
                </div>
          
            </div>
        </div>

        <div class="tab-content" id="orders">
            <h2>Order History</h2>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#7901</td>
                        <td>14 Jan 2026</td>
                        <td>Completed</td>
                        <td>3010 taka</td>
                    </tr>
                    <tr>
                        <td>#7892</td>
                        <td>02 Jan 2026</td>
                        <td>Pending</td>
                        <td>1250 taka</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="sales">
            <h2>Sales History</h2>
            <p>You haven't sold any products yet.</p>
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


<script src="../js/userdashboard.js"></script>

</body>
</html>
