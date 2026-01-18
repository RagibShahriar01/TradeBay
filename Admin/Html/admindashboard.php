<?php include "../php/admin_guard.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../user/Css/checkout.css">
  <link rel="stylesheet" href="../css/admindashboard.css">
</head>
<body>

  <h1 class="checkout-title">Admin Dashboard</h1>

  <div class="dashboard admin-dashboard">

    <!-- Sidebar -->
    <div class="dashboard-sidebar">
      <h3>ADMIN PANEL</h3>

      <button class="tab-btn active" data-target="overview">Admin Home</button>

      <button class="tab-btn" onclick="window.location.href='pending.php'">Pending list</button>
      <button class="tab-btn" onclick="window.location.href='approved.php'">Approve Product</button>

      <button class="tab-btn" onclick="window.location.href='categories.php'">Add Catalogy</button>

      <button class="tab-btn" onclick="window.location.href='orders.php'">Orders</button>

      <button class="tab-btn" onclick="window.location.href='deleteuser.php'">Users</button>



      

      <a href="../php/adminlogout.php" class="logout-link">Logout</a>
    </div>

    <!-- Content -->
    <div class="dashboard-content">

      <!-- Overview -->
      <div class="tab-content active" id="overview">
        <h2>Welcome</h2>
        <p class="welcome-text">
          <b>Admin,</b> <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>
        </p>

       
      </div>

      <!-- Listings -->
      <div class="tab-content" id="listings">
        <h2>Listings</h2>
        <div class="admin-links">
          <a class="admin-link" href="pending.php">Pending listing items</a>
          <a class="admin-link" href="approved.php">Approved products</a>
        </div>
      </div>

      <!-- Catalog -->
      <div class="tab-content" id="catalog">
        <h2>Catalog</h2>
        <div class="admin-links">
          <a class="admin-link" href="categories.php">Categories</a>
        </div>
      </div>

      <!-- Orders -->
      <div class="tab-content" id="orders">
        <h2>Orders</h2>
        <div class="admin-links">
          <a class="admin-link" href="orders.php">Order items</a>
        </div>
      </div>

      <!-- Users -->
      <div class="tab-content" id="users">
        <h2>Users</h2>
        <div class="admin-links">
          <a class="admin-link" href="deleteuser.php">Users</a>
        </div>
      </div>

    </div>
  </div>

  <script src="../js/admindashboard.js"></script>
</body>
</html>
