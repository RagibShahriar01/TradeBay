<?php
session_start();
include "../db/config.php";

$catId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

// category name
$catName = "Category";
$cq = $conn->prepare("SELECT name FROM categories WHERE id=? LIMIT 1");
$cq->bind_param("i", $catId);
$cq->execute();
$cr = $cq->get_result();
if($cr && $cr->num_rows > 0) $catName = $cr->fetch_assoc()["name"];

// products by category
$stmt = $conn->prepare("
  SELECT id, product_name, price, image_path
  FROM listings
  WHERE status='approved' AND category_id=?
  ORDER BY created_at DESC
");
$stmt->bind_param("i", $catId);
$stmt->execute();
$products = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo htmlspecialchars($catName); ?> | TradeBay</title>
  <link rel="stylesheet" href="../Css/home.css">
</head>
<body>


<div class="category-page-wrap" style="max-width:1200px;margin:35px auto;padding:0 20px;">
  <h2 style="font-size:22px;margin-bottom:18px;"><?php echo htmlspecialchars($catName); ?></h2>

  <div class="product-grid">
    <?php if($products && $products->num_rows > 0){ ?>
      <?php while($p = $products->fetch_assoc()){ ?>
        <a class="product-card" href="product.php?id=<?php echo (int)$p["id"]; ?>">
          <div class="product-img-wrap">
            <img src="../<?php echo htmlspecialchars($p["image_path"]); ?>" alt="">
          </div>
          <div class="product-meta">
            <p class="product-name"><?php echo htmlspecialchars($p["product_name"]); ?></p>
            <p class="product-price"><?php echo number_format((float)$p["price"],2); ?> taka</p>
          </div>
        </a>
      <?php } ?>
    <?php } else { ?>
      <p style="margin:20px 0;color:gray;">No products found in this category.</p>
    <?php } ?>
  </div>
</div>


</body>
</html>
