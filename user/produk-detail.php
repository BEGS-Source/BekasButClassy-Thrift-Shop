<?php
require "../koneksi.php";
require_once 'CBFEngine.php'; // Panggil file mesin rekomendasinya

// Validasi parameter GET
if (!isset($_GET['nama']) || empty($_GET['nama'])) {
    die("Nama produk tidak ditemukan.");
}

$nama = mysqli_real_escape_string($con, $_GET['nama']);
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");

// Cek apakah produk ditemukan
if (!$queryProduk || mysqli_num_rows($queryProduk) == 0) {
    die("Produk tidak ditemukan.");
}

$produk = mysqli_fetch_assoc($queryProduk);

// tambah view produk
$idProduk = $produk['id'];
mysqli_query($con, "UPDATE produk SET view_count = view_count + 1 WHERE id='$idProduk'");

// === perhitungan JACCARDNYA (Ditaruh setelah $produk didapet) ===
$rekomendasiEngine = new CBFEngine($con);
$produkTerkait = $rekomendasiEngine->getSimilarProduk($produk['id'], 4);
// ==============================================================
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <!-- Your Custom Styles -->
    <link rel="stylesheet" href="../CSS/style.css">
</head>

    <style>
        .floating-wa {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 35px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .floating-wa:hover {
            background-color: #128C7E;
            color: #fff;
            transform: scale(1.1);
        }
    </style>
<body>
    <?php require "navbar.php" ?>

    <div class="container-fluid py-5 pb-2">
        <div class="container detail-container">
            <div class="row produk-detail-row align-items-start">
                <!-- FOTO PRODUK -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <img src="../uploads/produk/<?php echo $produk['foto']; ?>"
                        class="w-100 detail-img rounded shadow-sm" alt="<?php echo $produk['nama']; ?>">
                </div>

                <!-- DETAIL PRODUK -->
                <div class="col-lg-7 produk-detail-text">
                    <h2 class="mb-3"><?php echo $produk['nama']; ?></h2>
                    <p class="text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                    <p class="fs-5 mb-4">
                        <?php echo nl2br(htmlspecialchars($produk['detail'])); ?>
                    </p>
                    <div class="alert alert-warning mt-3" style="border-radius: 12px;">
                        ⚠️ <strong>Heads up!</strong><br>
                        Jangan nawar kayak nawar kacang ya <br>
                        Nawar terlalu rendah langsung ditolak.
                    </div>
                    
                    <div class="d-flex gap-2 mb-4 mt-3">
                        <?php if ($produk['ketersediaan_stok'] == 'Ready') { ?>
                            <a href="checkout.php?id=<?php echo $produk['id']; ?>" class="btn btn-primary flex-fill fw-bold py-2">
                                <i class="fas fa-shopping-cart"></i> Checkout
                            </a>
                            <a href="penawaran.php?id=<?php echo $produk['id']; ?>" class="btn btn-warning flex-fill fw-bold text-dark py-2">
                                💰 Ajukan penawaran
                            </a>

                        <?php } else if ($produk['ketersediaan_stok'] == 'Reserved') { ?>
                            <button type="button" class="btn btn-secondary flex-fill fw-bold py-2" onclick="alert('Maaf kak, produk ini sedang dalam proses pemesanan (Reserved) oleh orang lain. Coba cek lagi nanti ya!');">
                                <i class="fas fa-shopping-cart"></i> Checkout
                            </button>
                            <button type="button" class="btn btn-secondary flex-fill fw-bold py-2" onclick="alert('Maaf kak, produk ini sedang di-reserved, penawaran ditutup sementara.');">
                                💰 Ajukan penawaran
                            </button>

                        <?php } else { ?>
                            <button class="btn btn-danger flex-fill fw-bold py-2 w-100" disabled>
                                <i class="fas fa-times-circle"></i> Terjual (Sold Out)
                            </button>
                        <?php } ?>
                    </div>

                    <p class="status mb-0">Status Ketersediaan:
                        <strong><?php echo $produk['ketersediaan_stok']; ?></strong>
                    </p>
                </div> </div> <hr class="my-5 opacity-25"> 
            
            <div class="row mb-1 justify-content-center"> <div class="col-12">
                    <div class="text-center mb-4">
                        <button class="btn btn-toggle-penawaran fw-bold px-4 py-2 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAktivitas" aria-expanded="false" aria-controls="collapseAktivitas">
                            <i class="fas fa-users me-2"></i> Lihat Aktivitas Penawaran <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                    </div>

                    <div class="collapse" id="collapseAktivitas">
                        <div class="pt-2 pb-4"> 
                            <?php
                            $id_produk_ini = $produk['id'];
                            $queryPenawaran = mysqli_query($con, "SELECT nama_penawar, harga_tawaran, tanggal FROM penawaran WHERE id_produk='$id_produk_ini' ORDER BY id DESC LIMIT 4");
                            
                            if(mysqli_num_rows($queryPenawaran) > 0) {
                                echo '<div class="row justify-content-center g-4 text-start">'; 
                                
                                while($tawar = mysqli_fetch_assoc($queryPenawaran)) {
                                    $nama_asli = $tawar['nama_penawar'];
                                    $nama_sensor = strlen($nama_asli) > 3 ? substr($nama_asli, 0, 3) . '***' : $nama_asli . '***';
                                    $waktu = date('d M Y', strtotime($tawar['tanggal']));
                                    
                                    echo '<div class="col-md-6">';
                                    echo '<div class="card card-penawar border-0 h-100">';
                                    echo '<div class="card-body text-center">'; 
                                    echo '<h6 class="nama-penawar fw-bold mb-1">' . htmlspecialchars($nama_sensor) . '</h6>';
                                    echo '<small class="waktu-penawar d-block mb-3">Menawar pada ' . $waktu . '</small>';
                                    echo '<div><span class="badge badge-harga rounded-pill px-4 py-2">Rp ' . number_format($tawar['harga_tawaran'], 0, ',', '.') . '</span></div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                echo '</div>'; 
                            } else {
                                echo '<div class="alert alert-penawar border-0 mt-3 text-center mx-auto shadow-sm">
                                        <i class="fas fa-box-open mb-3 fs-3 ikon-kosong"></i><br><span class="teks-kosong">Belum ada yang menawar. Jadilah yang pertama!</span>
                                      </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


    <!-- Produk Terkait -->
    </div> </div> </div> <div class="container-fluid py-5 warna1">
        <div class="container">
            <h2 class="bekasan-terkait-title">Rekomendasi Produk Untukmu</h2>
            <p class="text-center mb-4 text-muted">Berdasarkan produk yang sedang kamu lihat</p>
            
            <div class="row produk-terkait">
                <?php if (!empty($produkTerkait)) { ?>
                    <?php foreach ($produkTerkait as $data) { ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>">
                                    <img src="../uploads/produk/<?php echo $data['foto']; ?>"
                                        class="card-img-top bekasan-terkait-img" alt="<?php echo $data['nama']; ?>" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title fw-bold text-dark mb-1"><?php echo $data['nama']; ?></h5>
                                        <p class="fs-6 text-muted mb-3"><?php echo htmlspecialchars(substr($data['detail'], 0, 60)) . '...'; ?></p>
                                    </div>
                                    <div>
                                        <p class="card-text text-harga fw-bold text-danger mb-3">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                                        <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>"
                                            class="btn warna1 text-white btn-sm w-100">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-12 d-flex justify-content-center mt-4 mb-5">
                        <div class="alert alert-light text-dark shadow-sm fw-bold border-0 px-4 py-3" role="alert">
                            <i class="fas fa-box-open me-2 text-secondary"></i> Belum ada rekomendasi produk serupa.
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <?php require "footer.php" ?>



    <script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>