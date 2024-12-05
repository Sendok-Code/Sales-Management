<?php
include 'koneksi.php';

$query = "SELECT * FROM sales";
$result = $conn->query($query);
?>

<h3>Riwayat Transaksi</h3>
<table border="1">
    <tr>
        <th>ID Transaksi</th>
        <th>Total</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['sale_total'] ?></td>
            <td><?= $row['sales_status'] ?></td>
            <td><?= $row['sale_datetime'] ?></td>
        </tr>
    <?php } ?>
</table>
