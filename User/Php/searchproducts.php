<?php
session_start();
include "../db/config.php";

header("Content-Type: application/json; charset=UTF-8");

$q = trim($_GET["q"] ?? "");
$limit = 48;

if ($q === "") {
    $stmt = $conn->prepare("
        SELECT id, product_name, price, image_path
        FROM listings
        WHERE status='approved'
        ORDER BY created_at DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
} else {
    $like = "%" . $q . "%";
    $stmt = $conn->prepare("
        SELECT id, product_name, price, image_path
        FROM listings
        WHERE status='approved'
          AND product_name LIKE ?
        ORDER BY created_at DESC
        LIMIT ?
    ");
    $stmt->bind_param("si", $like, $limit);
}

$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) {
    $out[] = [
        "id" => (int)$row["id"],
        "product_name" => $row["product_name"],
        "price" => (float)$row["price"],
        "image_path" => $row["image_path"]
    ];
}

echo json_encode($out);
exit;
