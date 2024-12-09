<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar']['name'];

    // Tentukan folder penyimpanan
    $target = "uploads/";
    $file = $target . basename($gambar); // Pastikan nama file aman

    // Pindahkan file yang diunggah
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $file)) {
        // Simpan data ke database
        $query = "INSERT INTO products (nama, harga, gambar) VALUES ('$nama', '$harga', '$gambar')";
        if (mysqli_query($connection, $query)) {
            echo "Data berhasil ditambahkan.";
            header('Location: index.php');

        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
</head>
<body>
    <h2>Tambah Data Produk</h2>
    <form method="POST" action="create.php" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Harga:</label><br>
        <input type="number" name="harga" required><br>
        <label>Gambar:</label><br>
        <input type="file" name="gambar" required><br><br>
        <input type="submit" name="submit" value="Tambah Data">
    </form>
</body>
</html>
