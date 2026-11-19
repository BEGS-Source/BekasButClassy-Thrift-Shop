<?php
   require "../koneksi.php";
$queryKategori = mysqli_query($con, "SELECT * from kategori");

// --- LOGIKA FILTERING ---
$baseQuery = "";

// 1. Filter Keyword
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama LIKE '%$keyword%'");
    $kategoriIds = [];
    while ($row = mysqli_fetch_assoc($queryGetKategoriId)) {
        $kategoriIds[] = $row['id'];
    }

    if (count($kategoriIds) > 0) {
        $idList = implode(",", $kategoriIds);
        $baseQuery = "SELECT * FROM produk WHERE kategori_id IN ($idList)";
    } else {
        $baseQuery = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";
    }
} 
// 2. Filter Kategori
else if (isset($_GET['kategori'])) {
    $kategoriNama = mysqli_real_escape_string($con, $_GET['kategori']);
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama = '$kategoriNama'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $idKat = isset($kategoriId['id']) ? $kategoriId['id'] : 0; 
    $baseQuery = "SELECT * FROM produk WHERE kategori_id = '$idKat'";
} 
// 3. Tampil Semua (Default)
else {
    $baseQuery = "SELECT * FROM produk WHERE 1=1";
}

// 4. Filter Status
if (isset($_GET['status']) && $_GET['status'] != '') {
    $status = mysqli_real_escape_string($con, $_GET['status']);
    if (strpos($baseQuery, 'WHERE') !== false) {
        $baseQuery .= " AND ketersediaan_stok = '$status'";
    } else {
        $baseQuery .= " WHERE ketersediaan_stok = '$status'";
    }
}

// ==========================================
// --- FITUR BARU: LOGIKA PAGINATION ---
// ==========================================
$batas = 9; // Menampilkan 9 produk per halaman (Biar pas 3 baris grid)
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$awal_data = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total data keseluruhan (Sebelum di-limit)
$queryCount = mysqli_query($con, $baseQuery);
$countData = mysqli_num_rows($queryCount);
$total_halaman = ceil($countData / $batas);

// Tambahkan Limit ke Query Utama
$baseQuery .= " LIMIT $awal_data, $batas";

// Eksekusi Query Final
$queryProduk = mysqli_query($con, $baseQuery);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BekasButClassy Produk</title>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php require "navbar.php" ?>

    <!-- Banner -->
   <div class="container-fluid banner2 d-flex align-items-center justify-content-center">
    </div>

   <div class="container pt-4 pb-5">
        
        <h2 class="fw-bold mb-4 pb-2 border-bottom" style="color: #c9517a;">Daftar Produk</h2>
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3 class="text-center text-lg-start fw-bold mb-3 text-dark">Kategori</h3>
                
                <ul class="list-group mb-4">
                    <?php while($Kategori = mysqli_fetch_array($queryKategori)){ ?>
                    <a href="produk.php?kategori=<?= urlencode($Kategori['nama']) ?>" class="text-decoration-none">
                        <li class="list-group-item list-group-item-action">
                            <?= $Kategori['nama']; ?>
                        </li>
                    </a>
                    <?php } ?>
                </ul>
                <h3 class="text-center text-lg-start mt-4">Status</h3>
                <div class="list-group shadow-sm">
                    <a href="produk.php?status=Ready" class="list-group-item list-group-item-action <?= (isset($_GET['status']) && $_GET['status'] == 'Ready') ? 'active bg-success border-success text-white' : '' ?>">
                        <i class="fas fa-check-circle <?= (isset($_GET['status']) && $_GET['status'] == 'Ready') ? 'text-white' : 'text-success' ?> me-2"></i> Ready
                    </a>
                    <a href="produk.php?status=Reserved" class="list-group-item list-group-item-action <?= (isset($_GET['status']) && $_GET['status'] == 'Reserved') ? 'active bg-warning border-warning text-dark' : '' ?>">
                        <i class="fas fa-clock <?= (isset($_GET['status']) && $_GET['status'] == 'Reserved') ? 'text-dark' : 'text-warning' ?> me-2"></i> Reserved
                    </a>
                    <a href="produk.php?status=Sold" class="list-group-item list-group-item-action <?= (isset($_GET['status']) && $_GET['status'] == 'Sold') ? 'active bg-danger border-danger text-white' : '' ?>">
                        <i class="fas fa-times-circle <?= (isset($_GET['status']) && $_GET['status'] == 'Sold') ? 'text-white' : 'text-danger' ?> me-2"></i> Sold Out
                    </a>
                    <a href="produk.php" class="list-group-item list-group-item-action text-center text-muted bg-light">
                        <i class="fas fa-sync-alt me-1"></i> Tampilkan Semua
                    </a>
                </div>
            </div>

            

            <!-- Produk List -->
            <div class="col-lg-9">
                <h3 class="fw-bold mb-4 text-dark text-center">Produk</h3>
                
                <div class="row">
                    <?php if($countData < 1){ ?>
                        <div class="col-12">
                            <h5 class="text-center my-5 text-muted">Bekasan yang anda cari tidak tersedia</h5>
                        </div>
                    <?php } ?>

                    <?php while($produk = mysqli_fetch_array($queryProduk)){ ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            
                            <div class="image-box position-relative">
                                <img src="../uploads/produk/<?= $produk['foto']; ?>" class="card-img-top" alt="<?= $produk['nama']; ?>">
                                
                                <?php if($produk['ketersediaan_stok'] == 'Sold') { ?>
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">SOLD</span>
                                <?php } else if($produk['ketersediaan_stok'] == 'Reserved') { ?>
                                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">RESERVED</span>
                                <?php } else { ?>
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 shadow-sm rounded-pill">READY</span>
                                <?php } ?>
                            </div>

                            <div class="card-body bg-light text-center rounded-bottom">
                                <h5 class="card-title fw-semibold mb-2"><?= $produk['nama']; ?></h5>
                                <p class="card-text text-muted small mb-2"><?= nl2br(htmlspecialchars($produk['detail'])); ?></p>
                                <p class="card-text text-harga mb-3"><em>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></em></p>
                                <a href="produk-detail.php?nama=<?= urlencode($produk['nama']); ?>" class="btn warna1 text-white px-4">Detail</a>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                </div> <?php if($countData > 0): ?>
                <?php
                // Trik biar filter (Kategori/Status) gak hilang pas ganti halaman
                $url_params = "";
                if (isset($_GET['keyword'])) $url_params .= "&keyword=" . urlencode($_GET['keyword']);
                if (isset($_GET['kategori'])) $url_params .= "&kategori=" . urlencode($_GET['kategori']);
                if (isset($_GET['status'])) $url_params .= "&status=" . urlencode($_GET['status']);
                ?>
                
                <nav aria-label="Page navigation" class="mt-5 mb-4">
                    <ul class="pagination justify-content-center shadow-sm" style="border-radius: 10px; overflow: hidden; width: fit-content; margin: auto;">
                        
                        <li class="page-item <?= ($halaman <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link px-3 py-2" href="?halaman=<?= $halaman - 1 ?><?= $url_params ?>" aria-label="Previous">
                                <span aria-hidden="true" class="fw-bold">&laquo;</span>
                            </a>
                        </li>

                        <?php for($i = 1; $i <= $total_halaman; $i++): ?>
                            <li class="page-item <?= ($halaman == $i) ? 'active' : '' ?>">
                                <a class="page-link px-3 py-2 fw-bold" href="?halaman=<?= $i ?><?= $url_params ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : '' ?>">
                            <a class="page-link px-3 py-2" href="?halaman=<?= $halaman + 1 ?><?= $url_params ?>" aria-label="Next">
                                <span aria-hidden="true" class="fw-bold">&raquo;</span>
                            </a>
                        </li>
                        
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php" ?>

    <script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>