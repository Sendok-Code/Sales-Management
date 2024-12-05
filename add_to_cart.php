<?php
include 'koneksi.php';

$product_id = $_POST['product_id'];
$qty = $_POST['qty'];
$user_id = 1; // ID user (kasir) yang login.

$query = "SELECT * FROM products WHERE id = $product_id";
$product = $conn->query($query)->fetch_assoc();

if ($product['stock'] < $qty) {
    die("Stok tidak mencukupi.");
}

$unit_price = $product['price'];
$total_price = $qty * $unit_price;

// Tambahkan ke tabel temp_cart
$query = "INSERT INTO temp_cart (user_id, product_id, qty, unit_price, total_price) 
          VALUES ($user_id, $product_id, $qty, $unit_price, $total_price)";
$conn->query($query);

header("Location: index.php");
?>
