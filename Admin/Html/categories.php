<?php
include "../php/admin_guard.php";
include "../db/adminconfig.php";

$rows = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$msg = $_SESSION["adm_cat_msg"] ?? "";
unset($_SESSION["adm_cat_msg"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Categories</title>
  <link rel="stylesheet" href="../../user/Css/checkout.css">
  <link rel="stylesheet" href="../css/categories.css">
</head>
<body>

<h1 class="checkout-title">Categories</h1>

<div class="cat-wrap">
  <p class="msg"><?php echo $msg; ?></p>

  <form method="post" action="../php/categoryadds.php" class="cat-form">
    <input type="text" name="name" placeholder="New category name" class="cat-input" required>
    <button type="submit" name="add" class="search-btn">Add</button>
  </form>

  <table class="cat-table" border="1" cellpadding="10">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Delete</th>
    </tr>

    <?php while($r=$rows->fetch_assoc()){ ?>
      <tr>
        <td><?php echo $r["id"]; ?></td>
        <td><?php echo htmlspecialchars($r["name"]); ?></td>
        <td>
          <form method="post" action="../php/categorydeletes.php" onsubmit="return confirm('Remove category?');">
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
