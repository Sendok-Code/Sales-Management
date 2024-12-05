<?php
include 'koneksi.php';

$user_id = 1; // ID user yang login
$date = date('Y-m-d H:i:s');

// Buat transaksi baru
if ($conn->query("INSERT INTO transactions (user_id, transaction_date) VALUES ($user_id, '$date')")) {
    $transaction_id = $conn->insert_id;
} else {
    die("Error: " . $conn->error);
}

// Pindahkan data dari temp_cart ke cart
$temp_cart = $conn->query("SELECT * FROM temp_cart WHERE user_id = $user_id");

if ($temp_cart->num_rows > 0) {
    while ($item = $temp_cart->fetch_assoc()) {
        $product_id = $item['product_id'];
        $qty = $item['qty'];
        $price = $item['unit_price'];

        // Tambahkan ke tabel cart
        if (!$conn->query("INSERT INTO cart (transaction_id, product_id, qty, unit_price, total_price) 
                           VALUES ($transaction_id, $product_id, $qty, $price, $qty * $price)")) {
            die("Error: " . $conn->error);
        }

        // Kurangi stok di tabel products
        if (!$conn->query("UPDATE products SET stock = stock - $qty WHERE id = $product_id")) {
            die("Error: " . $conn->error);
        }
    }

    // Hapus data dari temp_cart
    $conn->query("DELETE FROM temp_cart WHERE user_id = $user_id");
} else {
    die("Keranjang kosong.");
}

header("Location: transactions.php");
exit;
?>
