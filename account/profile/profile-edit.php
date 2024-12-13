<?php
session_start();
include '../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $id = $_SESSION['user_id'];
    $namaD = $_POST["namadepan"];
    $namaB = $_POST["namabelakang"];
    $email = $_POST["email"];
    $nomer = $_POST["nomer"];

    // Cek apakah semua input kosong
    if (empty($namaD) && empty($namaB) && empty($email) && empty($nomer)) {
        // Jika semua input kosong, kembalikan ke halaman profil tanpa mengubah data
        header('Location: index.php');
        exit();
    }

    // Buat query update
    $query = "UPDATE users SET 
        nama_depan = '$namaD',
        nama_belakang = '$namaB',
        email = '$email',
        nomer = '$nomer'
        WHERE id = $id";

    // Eksekusi query
    if (mysqli_query($db, $query)) {
        echo "Data berhasil diperbarui.";
        header('Location: index.php');
        exit();
    } else {
        // Jika query gagal, tampilkan error
        echo "Error: " . mysqli_error($db);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Font Awesome -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.min.css"
  rel="stylesheet"
/>
<!-- Material Desain -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
<!-- ICON -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <style>
        input {
            font-weight: normal; /* Membuat teks tidak tebal */
        }
       
.cta {
  position: relative;
  margin: auto;
  padding: 12px 18px;
  transition: all 0.2s ease;
  border: none;
  background: none;
  cursor: pointer;
}

.cta:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  border-radius: 50px;
  background: #b1dae7;
  width: 45px;
  height: 45px;
  transition: all 0.3s ease;
}

.cta span {
  position: relative;
  font-family: "Ubuntu", sans-serif;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: 0.05em;
  color: #234567;
}

.cta svg {
  position: relative;
  top: 0;
  margin-left: 10px;
  fill: none;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke: #234567;
  stroke-width: 2;
  transform: translateX(-5px);
  transition: all 0.3s ease;
}

.cta:hover:before {
  width: 100%;
  background: #b1dae7;
}

.cta:hover svg {
  transform: translateX(0);
}

.cta:active {
  transform: scale(0.95);
}

/* From Uiverse.io by alexroumi */ 
button {
 padding: 15px 25px;
 border: unset;
 border-radius: 15px;
 color: #212121;
 z-index: 1;
 background: #e8e8e8;
 position: relative;
 font-weight: 1000;
 font-size: 17px;
 -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
 box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
 transition: all 250ms;
 overflow: hidden;
}

button::before {
 content: "";
 position: absolute;
 top: 0;
 left: 0;
 height: 100%;
 width: 0;
 border-radius: 15px;
 background-color: #212121;
 z-index: -1;
 -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
 box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
 transition: all 250ms
}

button:hover {
 color: #e8e8e8;
}

button:hover::before {
 width: 100%;
}

    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 mt-5 pt-5">
                <div class="row z-depth-3">
                    <div class="col-sm-4 bg-info rounded-left">
                        <div class="card-block text-center text-white">
                            <i class="fas fa-user-tie fa-7x mt-5"></i>
                            <h2 class="font-weight-bold mt-4">Haruto</h2>
                            <p>Customer</p>
                        </div>
                    </div>
                    <div class="col-sm-8 bg-white rounded-light">
                        <h3 class="mt-3 text-center">Edit Profile</h3>
                        <h4 class="mt-3">Nama Pengguna</h4>
                        <hr class="bg-primary">
                        <div class="row">
                          
                            <div class="col-sm-6">
                            <form action="" method="post">
                            <p class="font-weight-bold">
                            <i class="ri-user-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Nama Depan:
                            </p>
                                <input type="text" class="form-control" name="namadepan" placeholder="Masukkan nama depan">
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">
                                <i class="ri-user-star-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Nama Belakang:
                            </p>
                                <input type="text" class="form-control" name="namabelakang" placeholder="Masukkan nama belakang">
                            </div>
                        </div>
                        <hr class="badge-primary mt-0 w-25">
                        <div class="row">
                        <div class="col-sm-6">
                            <p class="font-weight-bold">
                                <i class="ri-mail-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Email:
                            </p>
                            <input type="text" class="form-control" name="email" placeholder="Masukkan email">
                        </div>
                        <div class="col-sm-6">
                            <p class="font-weight-bold">
                                <i class="ri-phone-line" style="margin-right: 8px; position: relative; top: 2px;"></i>No Handphone:
                            </p>
                            <input type="text" class="form-control" name="nomer" placeholder="Masukkan nomor handphone">
                        </div>
                        </div>
                        <hr class="bg-primary">
                        <div class="p-2">
                            <a href="#">
                                <button name="submit">Save</button>
                            </a>
                            </form>
                            <a href="index.php"> 
<button class="cta">
  <span>Back</span>
  <svg width="15px" height="10px" viewBox="0 0 13 10">
    <path d="M1,5 L11,5"></path>
    <polyline points="8 1 12 5 8 9"></polyline>
  </svg>
</button>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>