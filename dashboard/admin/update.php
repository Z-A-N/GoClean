<?php 
include "config.php";

$id = $_GET['id'];

// Ambil data produk berdasarkan ID
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $nama = $_POST["nama"];
    $harga = $_POST["harga"];

    // Cek apakah ada file gambar yang diunggah
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $target = "uploads/";
        $file = $target . $gambar;

        // Pindahkan file yang diunggah ke folder target
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $file)) {
            $gambar_path = $file;
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    } else {
        // Jika tidak ada file baru yang diunggah, gunakan gambar lama
        $gambar_path = $product['gambar'];
    }

    // Update data di database
    $query = "UPDATE products SET nama='$nama', harga='$harga', gambar='$gambar_path' WHERE id=$id";
    if (mysqli_query($connection, $query)) {
        echo "Data berhasil diperbarui.";
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Produk</title>
</head>
<body>
    <h2>Edit Data Produk</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo $product['nama']; ?>" required><br>
        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?php echo $product['harga']; ?>" required><br>
        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br>
        <small>* Biarkan kosong jika tidak ingin mengganti gambar</small><br><br>
        <input type="submit" name="update" value="Perbarui Data">
    </form>
</body>
</html>
