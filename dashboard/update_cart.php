<?php
session_start();
include 'admin/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['cart_id'];
$kuantitas = $_POST['kuantitas'];

// Pastikan kuantitas valid
if ($kuantitas < 1) {
    $kuantitas = 1;
}

$update = "UPDATE cart SET kuantitas = $kuantitas WHERE id = $cart_id AND user_id = $user_id";
if (mysqli_query($connection, $update)) {
    header('Location: cart.php');
    exit();
} else {
    echo "Gagal mengupdate kuantitas.";
}
?>
