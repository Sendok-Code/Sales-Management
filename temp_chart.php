<?php
include 'koneksi.php';

$user_id = 1; // Anggap pengguna sudah login

// Mengambil data keranjang sementara
$query = $conn->query("SELECT * FROM temp_cart WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Sementara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Keranjang Sementara</h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $query->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['product_id'] ?></td> <!-- Anda bisa mengambil nama produk disini -->
                <td>
                    <form method="post" action="update_quantity.php">
                        <input type="number" name="qty" value="<?= $row['qty'] ?>" class="form-control" min="1" required>
                        <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-primary mt-2">Perbarui</button>
                    </form>
                </td>
                <td><?= $row['unit_price'] ?></td>
                <td><?= $row['total_price'] ?></td>
                <td>
                    <form method="post" action="remove_from_cart.php">
                        <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="checkout.php" class="btn btn-primary">Selesaikan Pembelian</a>
</div>
</body>
</html>
