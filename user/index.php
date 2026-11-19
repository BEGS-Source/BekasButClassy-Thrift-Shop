<?php
require "../koneksi.php";
include "help_fab.php"; 
$notif = false;
$kodePesanan = '';



if (isset($_GET['pesan']) && $_GET['pesan'] == 'success') {
    $notif = true;
    $kodePesanan = $_GET['kode'];
}
$queryProduk = mysqli_query($con, "SELECT * FROM produk ORDER BY id DESC LIMIT 6");
$queryPopuler = mysqli_query($con, "SELECT * FROM produk ORDER BY view_count DESC LIMIT 6");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BekasButClassy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <!-- Your Custom Styles -->
    <link rel="stylesheet" href="../CSS/style.css?v=3">
    <style>
    /* Responsif teks banner home */
    @media (max-width: 992px) {
        .banner h1 { font-size: 2rem !important; }
        .banner h3 { font-size: 1rem !important; }
    }
    @media (max-width: 576px) {
        .banner h1 { font-size: 1.5rem !important; }
        .banner h3 { font-size: 0.875rem !important; }
        .kategori-card { height: 200px; }
    }
    /* Navbar pink button saat collapsed (mobile) */
    @media (max-width: 991px) {
        .btn-navbar-pink {
            display: inline-block;
            margin: 4px 0;
        }
        .navbar-nav .nav-item.ms-2 {
            margin-left: 0 !important;
        }
    }
    </style>

</head>
<body>
    <?php require "navbar.php"; ?>

    <style>
    .popup-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
        font-family: 'Poppins', sans-serif;
    }
    .popup-box {
        background: #fff; border-radius: 24px;
        padding: 32px 28px; width: 100%; max-width: 380px;
        text-align: center;
        box-shadow: 0 16px 60px rgba(0,0,0,0.2);
        position: relative; z-index: 9999;
    }
    .popup-icon-wrap {
        width: 64px; height: 64px; border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .popup-icon-wrap.pink  { background: linear-gradient(135deg, #FFCDD2, #F48FB1); }
    .popup-icon-wrap.green { background: linear-gradient(135deg, #a8edba, #43c06f); }
    .popup-icon-wrap i { font-size: 28px; color: white; }
    .popup-title { font-size: 18px; font-weight: 700; color: #212121; margin: 0 0 6px; }
    .popup-sub   { font-size: 13px; color: #888; margin: 0; line-height: 1.6; }
    .popup-divider { height: 1px; background: #FFCDD2; margin: 20px 0; }
    .popup-kode-label { font-size: 12px; color: #888; margin: 0 0 6px; }
    .popup-kode  { font-size: 24px; font-weight: 700; color: #F48FB1; letter-spacing: 1px; margin: 0 0 6px; }
    .popup-hint  { font-size: 11px; color: #bbb; margin: 0 0 4px; }
    .btn-popup-primary {
        display: block; width: 100%; height: 46px; border-radius: 13px;
        background: linear-gradient(135deg, #F48FB1, #e57da0);
        color: white; border: none; font-size: 14px; font-weight: 600;
        font-family: 'Poppins', sans-serif; text-decoration: none;
        line-height: 46px; cursor: pointer;
        box-shadow: 0 4px 14px rgba(244,143,177,0.4); margin-bottom: 10px;
        transition: all 0.2s;
    }
    .btn-popup-primary:hover { transform: translateY(-1px); color: white; }
    .btn-popup-secondary {
        display: block; width: 100%; height: 42px; border-radius: 12px;
        background: #FFF0F5; color: #F48FB1; border: 1.5px solid #FFCDD2;
        font-size: 13px; font-weight: 500; font-family: 'Poppins', sans-serif;
        text-decoration: none; line-height: 40px; cursor: pointer;
        margin-bottom: 8px; transition: all 0.2s;
    }
    .btn-popup-secondary:hover { background: #FFCDD2; color: #c9517a; }
    .btn-popup-ghost {
        display: block; width: 100%; height: 38px; border-radius: 10px;
        background: transparent; color: #bbb; border: 1.5px solid #eee;
        font-size: 12px; font-weight: 500; font-family: 'Poppins', sans-serif;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-popup-ghost:hover { background: #f5f5f5; color: #888; }
    </style>

    <?php if (isset($_GET['penawaran']) && $_GET['penawaran'] == 'success') { ?>
    <div class="popup-overlay" id="popupPenawaran">
        <div class="popup-box">
            <div class="popup-icon-wrap pink"><i class="fas fa-tags"></i></div>
            <p class="popup-title">Penawaran Terkirim!</p>
            <p class="popup-sub">Penawaran kamu sudah masuk ke admin.<br>Tunggu konfirmasi ya!</p>
            <div class="popup-divider"></div>
            <button onclick="document.getElementById('popupPenawaran').remove()" class="btn-popup-primary">OK, Siap!</button>
        </div>
    </div>
    <script>window.history.replaceState({}, document.title, "index.php");</script>
    <?php } ?>

    <?php if ($notif) { ?>
    <div class="popup-overlay" id="popupPesanan">
        <div class="popup-box">
            <div class="popup-icon-wrap green"><i class="fas fa-check"></i></div>
            <p class="popup-title">Pesanan Berhasil!</p>
            <p class="popup-sub">Simpan nomor pesanan ini untuk cek status kapan saja</p>
            <div class="popup-divider"></div>
            <p class="popup-kode-label">Nomor Pesanan</p>
            <p class="popup-kode">#<?= $kodePesanan ?></p>
            <p class="popup-hint">Catat atau screenshot nomor ini ya!</p>
            <a href="bayar.php?kode=<?= $kodePesanan ?>" class="btn-popup-primary">💳 Lanjutkan Pembayaran</a>
            <a href="cek-pesanan.php?kode=<?= $kodePesanan ?>" class="btn-popup-secondary">Cek Status Pesanan</a>
            <button onclick="document.getElementById('popupPesanan').remove()" class="btn-popup-ghost">Tutup</button>
        </div>
    </div>
    <script>window.history.replaceState({}, document.title, "index.php");</script>
    <?php } ?>

    <style>
    .popup-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
        font-family: 'Poppins', sans-serif;
    }
    .popup-box {
        background: #fff;
        border-radius: 24px;
        padding: 32px 28px;
        width: 100%; max-width: 380px;
        text-align: center;
        box-shadow: 0 16px 60px rgba(0,0,0,0.2);
        position: relative;
        z-index: 9999;
    }
    .popup-icon-wrap {
        width: 64px; height: 64px;
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .popup-icon-wrap.pink  { background: linear-gradient(135deg, #FFCDD2, #F48FB1); }
    .popup-icon-wrap.green { background: linear-gradient(135deg, #a8edba, #43c06f); }
    .popup-icon-wrap i { font-size: 28px; color: white; }
    .popup-title { font-size: 18px; font-weight: 700; color: #212121; margin: 0 0 6px; }
    .popup-sub   { font-size: 13px; color: #888; margin: 0; line-height: 1.6; }
    .popup-divider { height: 1px; background: #FFCDD2; margin: 20px 0; }
    .popup-kode-label { font-size: 12px; color: #888; margin: 0 0 6px; }
    .popup-kode  { font-size: 24px; font-weight: 700; color: #F48FB1; letter-spacing: 1px; margin: 0 0 6px; }
    .popup-hint  { font-size: 11px; color: #bbb; margin: 0 0 4px; }
    .btn-popup-primary {
        display: block; width: 100%; height: 46px; border-radius: 13px;
        background: linear-gradient(135deg, #F48FB1, #e57da0);
        color: white; border: none;
        font-size: 14px; font-weight: 600; font-family: 'Poppins', sans-serif;
        text-decoration: none; line-height: 46px; cursor: pointer;
        box-shadow: 0 4px 14px rgba(244,143,177,0.4); margin-bottom: 10px;
        transition: all 0.2s;
    }
    .btn-popup-primary:hover { transform: translateY(-1px); color: white; }
    .btn-popup-secondary {
        display: block; width: 100%; height: 42px; border-radius: 12px;
        background: #FFF0F5; color: #F48FB1; border: 1.5px solid #FFCDD2;
        font-size: 13px; font-weight: 500; font-family: 'Poppins', sans-serif;
        text-decoration: none; line-height: 40px; cursor: pointer;
        margin-bottom: 8px; transition: all 0.2s;
    }
    .btn-popup-secondary:hover { background: #FFCDD2; color: #c9517a; }
    .btn-popup-ghost {
        display: block; width: 100%; height: 38px; border-radius: 10px;
        background: transparent; color: #bbb; border: 1.5px solid #eee;
        font-size: 12px; font-weight: 500; font-family: 'Poppins', sans-serif;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-popup-ghost:hover { background: #f5f5f5; color: #888; }
    </style>

    <?php if (isset($_GET['penawaran']) && $_GET['penawaran'] == 'success') { ?>
    <div class="popup-overlay" id="popupPenawaran">
        <div class="popup-box">
            <div class="popup-icon-wrap pink">
                <i class="fas fa-tags"></i>
            </div>
            <p class="popup-title">Penawaran Terkirim!</p>
            <p class="popup-sub">Penawaran kamu sudah masuk ke admin.<br>Tunggu konfirmasi ya!</p>
            <div class="popup-divider"></div>
            <button onclick="document.getElementById('popupPenawaran').remove()" class="btn-popup-primary">
                OK, Siap!
            </button>
        </div>
    </div>
    <script>window.history.replaceState({}, document.title, "index.php");</script>
    <?php } ?>

    <?php if (isset($_GET['penawaran']) && $_GET['penawaran'] == 'diperbarui') { ?>
    <div class="popup-overlay" id="popupDiperbarui">
        <div class="popup-box">
            <div class="popup-icon-wrap pink">
                <i class="fas fa-tags"></i>
            </div>
            <p class="popup-title">Tawaran Diperbarui!</p>
            <p class="popup-sub">Tawaran sebelumnya belum direspons.<br>Nominal barumu berhasil ditumpuk di sistem!</p>
            <div class="popup-divider"></div>
            <button onclick="document.getElementById('popupDiperbarui').remove()" class="btn-popup-primary">
                OK, Siap!
            </button>
        </div>
    </div>
    <script>window.history.replaceState({}, document.title, "index.php");</script>
    <?php } ?>

    <?php if ($notif) { ?>
    <div class="popup-overlay" id="popupPesanan">
        <div class="popup-box">
            <div class="popup-icon-wrap green">
                <i class="fas fa-check"></i>
            </div>
            <p class="popup-title">Pesanan Berhasil!</p>
            <p class="popup-sub">Simpan nomor pesanan ini untuk cek status kapan saja</p>
            <div class="popup-divider"></div>
            <p class="popup-kode-label">Nomor Pesanan</p>
            <p class="popup-kode">#<?= $kodePesanan ?></p>
            <p class="popup-hint">Catat atau screenshot nomor ini ya!</p>
            <a href="bayar.php?kode=<?= $kodePesanan ?>" class="btn-popup-primary">
                💳 Lanjutkan Pembayaran
            </a>
            <a href="cek-pesanan.php?kode=<?= $kodePesanan ?>" class="btn-popup-secondary">
                Cek Status Pesanan
            </a>
            <button onclick="document.getElementById('popupPesanan').remove()" class="btn-popup-ghost">
                Tutup
            </button>
        </div>
    </div>
    <script>window.history.replaceState({}, document.title, "index.php");</script>
    <?php } ?>

    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center justify-content-center">
        <div class="container text-center text-white">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <h3 class="fs-5 mb-3 text-white" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.8); font-weight: 500;">Mau Cari Apa?</h3>
                    <form method="get" action="produk.php">
                        <div class="input-group input-group-lg shadow">
                            <input type="text" class="form-control" placeholder="Cari Bekasan" name="keyword">
                            <button type="submit" class="btn warna1 text-white px-4">Telusuri</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Overrated Section -->
    <div class="container-fluid py-5" style="background-color: #FFF0F5;">
        <div class="container text-center">
           <h2 class="text-center mb-4">KATEGORI TERBAIK</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                <div class="col">
                    <div class="kategori-card">
                        <img src="../image/vintage jacket.png" alt="jaket vintage">
                        <div class="kategori-label"><a href="produk.php?kategori=jaket vintage">Vintage Jacket</a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="kategori-card">
                        <img src="../image/celana cutbray.png" alt="Cutbray">
                        <div class="kategori-label"><a href="produk.php?kategori=celana cutbray">Celana Cutbray</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="kategori-card">
                        <img src="../image/Polo vintage shirts.png" alt="kemeja">
                        <div class="kategori-label"><a href="produk.php?kategori=baju polo vintage">Polo Vintage Shirts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- populer -->
    <div class="container-fluid py-5">
    <div class="container">
        <h2 class="text-center mb-4"> PRODUK POPULER </h2>
        <div class="row">
            <?php while($data = mysqli_fetch_array($queryPopuler)) { ?>
                <div class="col-6 col-md-4 col-lg-2 mb-4">
                    <div class="card h-100">
                        <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>">
                        <div class="image-box position-relative"> 
                            <img src="../uploads/produk/<?php echo $data['foto']; ?>" 
                                class="card-img-top img-populer" alt="<?php echo $data['nama']; ?>">
                            
                            <?php if($data['ketersediaan_stok'] == 'Sold') { ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">SOLD</span>
                            <?php } else if($data['ketersediaan_stok'] == 'Reserved') { ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">RESERVED</span>
                            <?php } else { ?>
                                <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">READY</span>
                            <?php } ?>
                        </div>
                        </a>
                        <div class="card-body text-center">
                            <h6 class="card-title"><?php echo $data['nama']; ?></h6>
                            <p class="text-harga">
                                Rp <?php echo number_format($data['harga'],0,',','.'); ?>
                            </p>
                            <p class="text-muted">Dilihat <?php echo $data['view_count']; ?>x</p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

    <!-- Produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h2 class="text-center mb-4">BEKASAN TERBARU </h2>
            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box position-relative"> 
                            <img src="../uploads/produk/<?php echo $data['foto']; ?>" 
                                class="card-img-top img-populer" alt="<?php echo $data['nama']; ?>">
                            
                            <?php if($data['ketersediaan_stok'] == 'Sold') { ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">SOLD</span>
                            <?php } else if($data['ketersediaan_stok'] == 'Reserved') { ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">RESERVED</span>
                            <?php } else { ?>
                                <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">READY</span>
                            <?php } ?>
                        </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($data['detail'])); ?></p>
                                <p class="card-text text-harga">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>
                                </p>
                                <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>"
                                    class="btn warna1 text-white">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-warning mt-3" href="produk.php">See more</a>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php"; ?>

    <script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>