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
    $total_price = 0;
    $total_produk = 0; // Hitung total jumlah produk
    while ($row = mysqli_fetch_assoc($result)) {
        $row['total'] = $row['harga'] * $row['kuantitas'];
        $total_price += $row['total'];
        $total_produk += $row['kuantitas'];
        $cart_items[] = $row;
    }
} else {
    header('Location: keranjang.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    $telepon = mysqli_real_escape_string($connection, $_POST['telepon']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $metode = mysqli_real_escape_string($connection, $_POST['metode']);
    $alamat1 = mysqli_real_escape_string($connection, $_POST['alamat1']);
    $alamat2 = mysqli_real_escape_string($connection, $_POST['alamat2']);
    $kota = mysqli_real_escape_string($connection, $_POST['kota']);
    $provinsi = mysqli_real_escape_string($connection, $_POST['provinsi']);
    $negara = mysqli_real_escape_string($connection, $_POST['negara']);
    $kode_pos = mysqli_real_escape_string($connection, $_POST['kode_pos']);

    // Simpan data ke tabel orders
    $query = "INSERT INTO orders (nama, nomor, email, metode, alamat1, alamat2, kota, provinsi, negara, kode_pos, total_produk, total_harga) 
              VALUES ('$nama', '$telepon', '$email', '$metode', '$alamat1', '$alamat2', '$kota', '$provinsi', '$negara', '$kode_pos', '$total_produk', '$total_price')";
    if (mysqli_query($connection, $query)) {
        $order_id = mysqli_insert_id($connection);

        // Simpan detail pesanan
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $kuantitas = $item['kuantitas'];
            $harga = $item['harga'];
            $query = "INSERT INTO order_details (order_id, product_id, kuantitas) VALUES ('$order_id', '$product_id', '$kuantitas')";
            mysqli_query($connection, $query);
        }

        // Kosongkan keranjang
        $query = "DELETE FROM cart WHERE user_id = '$user_id'";
        mysqli_query($connection, $query);

        // Redirect ke halaman sukses
        header('Location: sukses.php?order_id=' . $order_id);
        exit();
    } else {
        $error_message = "Gagal memproses pesanan Anda. Silakan coba lagi.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Checkout</h1>
        <h3>Ringkasan Pesanan</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['nama']; ?></td>
                    <td><img src="admin/uploads/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>" class="img-fluid" style="max-height: 80px; object-fit: cover;"></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['kuantitas']; ?></td>
                    <td>Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total Harga: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></h4>

        <h3>Informasi Pengiriman</h3>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Penerima</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="metode" class="form-label">Metode Pembayaran</label>
                <select name="metode" id="metode" class="form-control" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">Bayar di Tempat (COD)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat1" class="form-label">Alamat 1</label>
                <input type="text" name="alamat1" id="alamat1" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="alamat2" class="form-label">Alamat 2 (Opsional)</label>
                <input type="text" name="alamat2" id="alamat2" class="form-control">
            </div>
            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="negara" class="form-label">Negara</label>
                <input type="text" name="negara" id="negara" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kode_pos" class="form-label">Kode Pos</label>
                <input type="text" name="kode_pos" id="kode_pos" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Selesaikan Pesanan</button>
        </form>
    </div>
</body>
</html>
