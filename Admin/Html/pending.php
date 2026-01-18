<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$rows = $conn->query("SELECT l.*, c.name AS cat_name, u.name AS seller_name, u.email AS seller_email
                      FROM listings l
                      JOIN categories c ON c.id=l.category_id
                      JOIN users u ON u.id=l.user_id
                      WHERE l.status='pending'
                      ORDER BY l.created_at DESC");

$msg = $_SESSION["adm_pending_msg"] ?? "";
unset($_SESSION["adm_pending_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Pending Listings</title>
  <link rel="stylesheet" href="../../user/Css/checkout.css">
  <link rel="stylesheet" href="../css/pending.css">
</head>
<body>

<h1 class="checkout-title">Pending listing items</h1>

<div class="pending-wrap">
  <p class="msg"><?php echo $msg; ?></p>

  <table class="pending-table" border="1" cellpadding="10">
    <tr>
      <th>Image</th>
      <th>Product</th>
      <th>Category</th>
      <th>Condition</th>
      <th>Location</th>
      <th>Price</th>
      <th>Seller</th>
      <th>Action</th>
    </tr>

    <?php while($r=$rows->fetch_assoc()){ ?>
      <tr>
        <td>
          <img class="thumb" src="../../user/<?php echo $r["image_path"]; ?>" alt="Product">
        </td>

        <td>
          <b><?php echo htmlspecialchars($r["product_name"]); ?></b><br>
          <span class="desc"><?php echo nl2br(htmlspecialchars($r["description"])); ?></span>
        </td>

        <td><?php echo htmlspecialchars($r["cat_name"]); ?></td>
        <td><?php echo htmlspecialchars($r["item_condition"]); ?></td>
        <td><?php echo htmlspecialchars($r["location"]); ?></td>
        <td><?php echo number_format($r["price"],2); ?> taka</td>

        <td>
          <?php echo htmlspecialchars($r["seller_name"]); ?><br>
          <span class="seller-email"><?php echo htmlspecialchars($r["seller_email"]); ?></span>
        </td>

        <td>
          <form method="post" action="../php/pendingactions.php" class="approve-form">
            <input type="hidden" name="id" value="<?php echo $r["id"]; ?>">
            <button type="submit" name="approve" class="btn-approve">Approve</button>
          </form>

          <form method="post" action="../php/pendingactions.php" class="reject-form">
            <input type="hidden" name="id" value="<?php echo $r["id"]; ?>">
            <input type="text" name="reason" placeholder="Reject reason" class="reason-input">
            <button type="submit" name="reject" class="btn-reject">Reject</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </table>

  <p class="back-row"><a href="admindashboard.php">← Back</a></p>
</div>

</body>
</html>
