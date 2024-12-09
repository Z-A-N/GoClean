<?php
session_start();
include 'admin/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $kuantitas = $_POST['kuantitas'];
    $check_user = "SELECT * FROM users WHERE id = $user_id";
    $result_user = mysqli_query($connection, $check_user);

if (mysqli_num_rows($result_user) == 0) {
    die("User tidak ditemukan."); // Jika user tidak ada di tabel users, hentikan
}

// Cek apakah produk sudah ada di keranjang
$check_cart = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
$result_cart = mysqli_query($connection, $check_cart);

if (mysqli_num_rows($result_cart) > 0) {
    // Produk sudah ada, update jumlah produk
    $update = "UPDATE cart SET kuantitas = kuantitas + $kuantitas WHERE user_id = $user_id AND product_id = $product_id";
    if (mysqli_query($connection, $update)) {
        echo "Jumlah berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui jumlah produk.";
    }
} else {
    $insert = "INSERT INTO cart (user_id, product_id, kuantitas) VALUES ($user_id, $product_id, $kuantitas)";
    if (mysqli_query($connection, $insert)) {
        echo "Berhasil ditambahkan ke keranjang.";
    } else {
        echo "Gagal menambahkan produk ke keranjang.";
    }
}
    header('Location: ./');
    exit();

?>