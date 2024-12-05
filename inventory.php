<?php
include 'koneksi.php';

$products = $conn->query("SELECT * FROM products");
?>

<h1>Stok Produk</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $products->fetch_assoc()) { ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['stock'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
