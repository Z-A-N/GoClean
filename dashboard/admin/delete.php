<?php
include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil informasi produk berdasarkan ID
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($result);

if ($product) {
    // Pastikan path gambar sudah lengkap
    $gambar_path = 'uploads/' . $product['gambar'];

    // Cek apakah file gambar ada di folder uploads
    if (file_exists($gambar_path)) {
        if (unlink($gambar_path)) {
            echo "File gambar berhasil dihapus.";
        } else {
            echo "Gagal menghapus file gambar.";
        }
    } else {
        echo "File gambar tidak ditemukan.";
    }

    // Hapus data dari database
    $delete_query = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($connection, $delete_query)) {
        echo "Data berhasil dihapus.";
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $delete_query . "<br>" . mysqli_error($connection);
    }
} else {
    echo "Data tidak ditemukan.";
}
?>
