<?php
session_start();
include 'admin/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "
    SELECT cart.*, products.nama, products.harga, products.gambar
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $cart_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
} else {
    $cart_items = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Keranjang Belanja</h1>
        <?php if (count($cart_items) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total_price = 0;
                    foreach ($cart_items as $item):
                        $total_item_price = $item['harga'] * $item['kuantitas'];
                        $total_price += $total_item_price;
                    ?>
                <tr>
                    <td><?php echo $item['nama']; ?></td>
                    <td>
                        <img src="admin/uploads/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>"
                            class="img-fluid" style="max-height: 80px; object-fit: cover;">
                    </td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="update_cart.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="kuantitas" value="<?php echo $item['kuantitas']; ?>" min="1"
                                max="99" style="width: 60px;">
                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                        </form>
                    </td>
                    <td>Rp <?php echo number_format($total_item_price, 0, ',', '.'); ?></td>
                    <td>
                        <form action="remove_cart_item.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h3>Total: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></h3>
            <a href="checkout.php" class="btn btn-success">Checkout</a>
        </div>
        <?php else: ?>
        <p>Keranjang Anda kosong.</p>
        <?php endif; ?>
    </div>
</body>

</html>