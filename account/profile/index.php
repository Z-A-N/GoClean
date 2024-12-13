<?php
session_start();
include '../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Query langsung tanpa prepared statement
$sql = "SELECT username, nama_depan, nama_belakang, nomer, email FROM users WHERE id = $user_id";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Ambil data pengguna
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <style>
        input {
            font-weight: normal; 
        }

        .button-container {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: center;
        gap: 15px; 
        margin-top: 10px;
        }

button {
 padding: 0.5em 1.5em;
 border: 2px solid  #0DCAF0;
 position: relative;
 overflow: hidden;
 background-color: transparent;
 text-align: center;
 text-transform: uppercase;
 font-size: 16px;
 transition: .3s;
 z-index: 1;
 font-family: inherit;
 color:  #0DCAF0;
}

button::before {
 content: '';
 width: 0;
 height: 300%;
 position: absolute;
 top: 50%;
 left: 50%;
 transform: translate(-50%, -50%) rotate(45deg);
 background:  #0DCAF0;
 transition: .5s ease;
 display: block;
 z-index: -1;
}

button:hover::before {
 width: 105%;
}

button:hover {
 color: white;
}

@media (max-width: 768px) {
  button {
    width: 100%; 
  }

  .button-container {
    flex-direction: row; 
    gap: 10px;
  }
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
                            <h2 class="font-weight-bold mt-4"><?php echo $user['username']; ?></h2>
                            <p>Customer</p>
                        </div>
                    </div>
                    <div class="col-sm-8 bg-white rounded-light">
                        <h3 class="mt-3 text-center">Informasi</h3>
                        <h4 class="mt-3">Nama Pengguna</h4>
                        <hr class="bg-primary">
                        <div class="row">
                            <div class="col-sm-6">
                            <p class="font-weight-bold">
                            <i class="ri-user-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Nama Depan:
                            </p>
                                <h6 class="text-muted"><?php echo $user['nama_depan']; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">
                                <i class="ri-user-star-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Nama Depan:
                            </p>
                                <h6 class="text-muted"><?php echo $user['nama_belakang']; ?></h6>
                            </div>
                        </div>
                        <hr class="badge-primary mt-0 w-25">
                        <div class="row">
                        <div class="col-sm-6">
                            <p class="font-weight-bold">
                                <i class="ri-mail-line" style="margin-right: 8px; position: relative; top: 2px;"></i>Email:
                            </p>
                            <h6 class="text-muted"><?php echo $user['email']; ?></h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="font-weight-bold">
                                <i class="ri-phone-line" style="margin-right: 8px; position: relative; top: 2px;"></i>No Handphone:
                            </p>
                            <h6 class="text-muted"><?php echo $user['nomer']; ?></h6>
                        </div>
                        </div>
                        <hr class="bg-primary">
                        <div class="text-center" style="margin-top: 20px;"> <!-- Tambahkan margin-top negatif -->
                        <div class="text-center button-container">
                          <a href="profile-edit.php" class="mb-3">                                                                      
                            <button>Edit</button>
                          </a>
                          <a href="profile-delete.php" class="mb-3">                                     
                            <button>Hapus</button>
                          <a href="logout.php" class="mb-3">  
                            <button>Logout</button>
                          </a>
                        </div>                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>