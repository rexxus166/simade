<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMADE</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
   
    <!-- Navbar start -->
    <nav class="navbar">
      <a href="" class="navbar-logo">SIMADE<span>POLINDRA</span>.</a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#artikel">Artikel</a>
        <a href="#contact">Pesan</a>
      </div>

      <div class="navbar-extra">
        <?php if (isset($_SESSION['username'])): ?>
          <!-- Jika sudah login, tampilkan tombol Logout -->
          <a href="logout.php" class="login-btn">Logout</a>
        <?php else: ?>
          <!-- Jika belum login, tampilkan tombol Login -->
          <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>

    <!-- Navbar end -->


    <!-- Hero Section start -->
    <section class="hero" id="home">
      <div class="mask-container">
        <main class="content">
          <h1>SIMADE<span>POLINDRA</span></h1>
          <p>
          (Sistem Informasi Masyarakat Desa)
          </p>
        </main>
      </div>
    </section>
    <!-- Hero Section end -->

    <!-- About Section start -->
    <section id="about" class="about">
      <h2><span>Tentang</span> Kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="img/tentang-kami.jpg" alt="Tentang Kami" />
        </div>
        <div class="content">
          <h3>SIMADE</h3>
          <p>
            SIMADE adalah sebuah website yang dibuat untuk masyarakat desa dengan tujuan agar semakin mudah nya mendapat informasi terkini dari pemerintah desa
          </p>
        </div>
      </div>
    </section>
    <!-- About Section end -->

<!-- artikel section -->
<section id="artikel" class="menu py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title mb-3">
                    <span class="text-primary">Artikel</span> Kami
                </h2>
                <p class="text-muted">
                    Temukan informasi terbaru dan berita menarik dari desa.
                </p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            include 'koneksi/koneksi.php';
            $query = "SELECT * FROM artikel LIMIT 6";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $gambar = !empty($row['gambar']) ? 'uploads/' . htmlspecialchars($row['gambar']) : 'img/default-article.jpg';
            ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="card-img-wrapper">
                                <img src="<?php echo $gambar; ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($row['judul']); ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">
                                    <?php echo htmlspecialchars($row['judul']); ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo substr(htmlspecialchars($row['konten']), 0, 100) . '...'; ?>
                                </p>
                                <a href="detail_artikel.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-primary mt-auto">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
            ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada artikel yang ditambahkan.
                    </div>
                </div>
            <?php
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</section>





    <!-- Contact Section start -->
    <section id="contact" class="contact">
      <h2><span>Kirim</span>Pesan</h2>
      <p>
      </p>

      <div class="row">
    <form action="process_contact.php" method="POST"> <!-- Pastikan action mengarah ke file PHP -->
        <div class="input-group">
            <i data-feather="user"></i>
            <input type="text" name="name" placeholder="Nama" required />
        </div>
        <div class="input-group">
            <i data-feather="mail"></i>
            <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="input-group">
            <i data-feather="message-square"></i>
            <input type="pesan" name="message" placeholder="Pesan" required>
        </div>
        <button type="submit" class="btn">Kirim Pesan</button>
    </form>
</div>

    </section>
    <!-- Contact Section end -->

    <!-- Footer start -->
    <footer>
      <div class="socials">
        <a href="#"><i data-feather="instagram"></i></a>
        <a href="#"><i data-feather="twitter"></i></a>
        <a href="#"><i data-feather="facebook"></i></a>
      </div>

      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#menu">Artikel</a>
        <a href="#contact">Kontak</a>
      </div>

      <div class="credit">
        <p>Created by <a href="">Kelompok 8</a>
      </div>
    </footer>
    <!-- Footer end -->
    <!-- Feather Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Javascript -->
    <script src="js/script.js"></script>
  </body>
</html>
