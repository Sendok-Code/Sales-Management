<?php
include 'koneksi.php';

// Pencarian produk
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM products WHERE name LIKE '%$search%'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Sales Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transactions.php">Riwayat Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inventory.php">Stok Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Daftar Produk</h1>
    <form class="mb-4 d-flex" method="get" action="">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['stock'] ?></td>
                <td>
                    <form method="post" action="add_to_cart.php" class="d-flex">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <input type="number" name="qty" class="form-control me-2" min="1" max="<?= $row['stock'] ?>" required>
                        <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php
    // Tampilkan keranjang
    $user_id = 1; // ID user yang login.
    $query = "SELECT temp_cart.*, products.name 
              FROM temp_cart 
              JOIN products ON temp_cart.product_id = products.id
              WHERE temp_cart.user_id = $user_id";
    $result = $conn->query($query);
    ?>

    <h3 class="mt-5 mb-4">Keranjang</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['qty'] ?></td>
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

    <div class="text-end mt-4">
        <a href="checkout.php" class="btn btn-primary">Proses Pembelian</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
