<?php
include 'koneksi.php';

$cart_id = $_POST['cart_id'];

$query = "DELETE FROM temp_cart WHERE id = $cart_id";
$conn->query($query);

header("Location: index.php");
?>
