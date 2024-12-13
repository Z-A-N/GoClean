<?php
session_start();
include '../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}


$user_id = $_SESSION['user_id'];
$user_id = $_POST['id'];

$delete = "DELETE FROM users WHERE id = $cart_id AND user_id = $user_id";
if (mysqli_query($db, $delete)) {
    header('Location: index.php');
    exit();
} else {
    echo "Gagal menghapus item dari keranjang.";
}
?>