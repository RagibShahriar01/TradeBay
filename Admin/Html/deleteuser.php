<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$rows = $conn->query("SELECT id,name,email,phone,created_at FROM users ORDER BY id DESC");
$msg = $_SESSION["adm_user_msg"] ?? "";
unset($_SESSION["adm_user_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Users</title>
  <link rel="stylesheet" href="../../user/Css/checkout.css">
  <link rel="stylesheet" href="../css/deleteusers.css">
</head>
<body>

<h1 class="checkout-title">Users</h1>

<div class="users-wrap">
  <p class="msg"><?php echo $msg; ?></p>

  <table class="users-table" border="1" cellpadding="10">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Created</th>
      <th>Delete</th>
    </tr>

    <?php while($r=$rows->fetch_assoc()){ ?>
      <tr>
        <td><?php echo $r["id"]; ?></td>
        <td><?php echo htmlspecialchars($r["name"]); ?></td>
        <td><?php echo htmlspecialchars($r["email"]); ?></td>
        <td><?php echo htmlspecialchars($r["phone"]); ?></td>
        <td><?php echo htmlspecialchars($r["created_at"]); ?></td>
        <td>
          <form method="post" action="../php/deleteusers.php" onsubmit="return confirm('Delete this user and all listings/orders?');">
            <input type="hidden" name="id" value="<?php echo $r["id"]; ?>">
            <button type="submit" name="delete" class="btn-delete">Delete</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </table>

  <p class="back-row"><a href="admindashboard.php">← Back</a></p>
</div>

</body>
</html>
