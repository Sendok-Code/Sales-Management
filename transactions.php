<?php
include 'koneksi.php';

$user_id = 1; // ID user yang login
$transactions = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY transaction_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Riwayat Transaksi</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Detail Produk</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaction = $transactions->fetch_assoc()) { ?>
                    <?php
                    $transaction_id = $transaction['id'];
                    $details = $conn->query("SELECT cart.*, products.name FROM cart JOIN products ON cart.product_id = products.id WHERE cart.transaction_id = $transaction_id");
                    $total = 0;
                    ?>
                    <tr>
                        <td><?= $transaction['transaction_date'] ?></td>
                        <td>
                            <ul>
                                <?php while ($detail = $details->fetch_assoc()) { ?>
                                    <li><?= $detail['name'] ?> (<?= $detail['qty'] ?> x <?= $detail['unit_price'] ?>)</li>
                                    <?php $total += $detail['total_price']; ?>
                                <?php } ?>
                            </ul>
                        </td>
                        <td><?= number_format($total, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
