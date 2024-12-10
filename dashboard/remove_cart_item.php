<?php
session_start();
include 'admin/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['cart_id'];

$delete = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
if (mysqli_query($connection, $delete)) {
    header('Location: cart.php');
    exit();
} else {
    echo "Gagal menghapus item dari keranjang.";
}
?>
