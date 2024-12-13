<?php
session_start();
include '../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}

$id = $_SESSION['user_id'];
 

$query_cart = "DELETE FROM cart WHERE user_id = $id";
mysqli_query($db, $query_cart);
$query = "DELETE FROM users WHERE id = $id";
if (mysqli_query($db, $query)) {
header('Location:../');
exit();
} else {
echo "Error: " . mysqli_error($db);
}

?>