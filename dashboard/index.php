<?php
   session_start();
   include 'admin/config.php';
   if (!isset($_SESSION['user_id'])) {
    header('Location: ../account/index.php');
    exit();
}
   $sql = "SELECT * FROM products";
   $result = $connection->query($sql);
   $user_id = $_SESSION['user_id'];


$total_items = "SELECT SUM(kuantitas) AS total_items FROM cart WHERE user_id = $user_id";
$result_total_items = mysqli_query($connection, $total_items);
$row = mysqli_fetch_assoc($result_total_items);
$total_items = $row['total_items'] ? $row['total_items'] : 0;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoClean</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="./assets/css/style.css">
</head>


<body class="bg-gray-50">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-shadow" id="navv">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <img src="assets/png/logo.png" alt="Logo" width="40" height="40"
                    class="d-inline-block align-text-top" />
                <div class="ms-2">
                    <strong>GoClean</strong>
                </div>
            </a>

            <!-- Toggler (Untuk tampilan mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div id="navbarNav" class="collapse navbar-collapse">
                <!-- Navbar Left: Teks Promo -->
                <div class="bg-gray-100 text-center py-2 text-sm w-100 d-lg-block">
                    <span>Fresh, Clean, Ready To Wear</span>
                </div>

                <!-- Navbar Center: Search -->
                <form class="d-flex me-3 w-100" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <!-- Navbar Right: Keranjang dan Login -->
                <div class="d-flex ms-auto">
                    <button class="btn btn-outline-secondary me-2 position-relative" data-bs-toggle="modal"
                        data-bs-target="#cartModal" aria-label="Lihat Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($total_items > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $total_items; ?>
                            <span class="visually-hidden">Total Items</span>
                        </span>
                        <?php endif; ?>
                    </button>


                    <a href="login" class="btn btn-outline-secondary">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Modal Keranjang -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Keranjang Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Menampilkan daftar produk di keranjang -->
                    <?php
                $sql_cart = "SELECT p.nama, p.harga, c.kuantitas, p.gambar 
                             FROM cart c
                             JOIN products p ON c.product_id = p.id
                             WHERE c.user_id = $user_id";
                $result_cart = mysqli_query($connection, $sql_cart);

                if (mysqli_num_rows($result_cart) > 0) {
                    while ($cart_item = mysqli_fetch_assoc($result_cart)) {
                        ?>
                    <div class="row mb-3">
                        <div class="col-4">
                            <img src="admin/uploads/<?php echo $cart_item['gambar']; ?>"
                                alt="<?php echo $cart_item['nama']; ?>" class="img-fluid"
                                style="height: 80px; object-fit: cover;">
                        </div>
                        <div class="col-8">
                            <h6><?php echo $cart_item['nama']; ?></h6>
                            <p>Rp <?php echo number_format($cart_item['harga'], 0, ',', '.'); ?></p>
                            <p>Jumlah: <?php echo $cart_item['kuantitas']; ?></p>
                        </div>
                    </div>
                    <?php
                    }
                } else {
                    echo "<p>Keranjang Anda kosong.</p>";
                }
                ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="cart.php" class="btn btn-primary">Lihat Keranjang</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Untuk dashboard bagian atas -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/png/laundry 2.jpg" class="d-block w-100" alt="Laundry Image 2" />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Pakaian Bebas Bau</h5>
                    <p>Hirup kesegaran dari pakaian yang wangi dan bersih.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/png/laundry 3.jpg" class="d-block w-100" alt="Laundry Image 3" />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Kain Lembut dan Segar</h5>
                    <p>Rasakan kelembutan dan keharuman di setiap serat kain.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">Selamat Datang
                        <?= $_SESSION ["username"] ?></h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">LEAVE THE LAUNDRY TO US - YOUR CLOTHES
                        DESERVE THE BEST</h5>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <a href="#" class="btn btn-brand me-2">About Us</a>
                        <a href="#" class="btn btn-light ms-2">Our Services</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Item Produk -->
    <section id="products" class="section-padding bg-light">
        <div class="container mt-5">
            <h1 class="text-center">Product List</h1>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Gambar Produk -->
                        <img src="admin/uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>"
                            class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                            <p class="card-text">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <form action="to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

                                <div class="input-group mb-2 justify-content-center d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="decrementQuantity(<?php echo $row['id']; ?>)">
                                        <i class="ri-subtract-fill"></i><!-- Icon minus -->
                                    </button>
                                    <input type="number" id="quantity-<?php echo $row['id']; ?>" name="kuantitas"
                                        value="1" min="1" class="form-control text-center" style="max-width: 60px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="incrementQuantity(<?php echo $row['id']; ?>)">
                                        <i class="ri-add-fill"></i> <!-- Icon plus -->
                                    </button>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <a href="#"><img src="" alt=""></a>
                        <div class="line"></div>
                        <p>Laundry berkualitas untuk style terbaik anda setiap hari!</p>
                        <div class="social-icons">
                            <a href="#"><i class="ri-instagram-fill"></i></a>
                            <a href="#"><i class="ri-github-fill"></i></a>
                            <a href="#"><i class="ri-linkedin-box-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SERVICES</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#services">Cuci Kilat</a></li>
                            <li><a href="#services">Cuci Kiloan</a></li>
                            <li><a href="#services">Sepatu</a></li>
                            <li><a href="#services">Boneka</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">ABOUT</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#about">Blog</a></li>
                            <li><a href="#about">Services</a></li>
                            <li><a href="#about">Akun</a></li>
                            <li><a href="#reviews">Testimonials</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACT</h5>
                        <div class="line"></div>
                        <ul>
                            <li>Purbalingga, IDN 5321</li>
                            <li>(+62) 856 0177 8422</li>
                            <li>234110601047@mhs.uinsaizu.ac.id</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-auto">
                        <p class="mb-0">© Copyright GoClean. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>