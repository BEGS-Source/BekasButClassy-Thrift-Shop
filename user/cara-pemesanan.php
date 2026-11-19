<?php
// Tidak perlu require koneksi.php karena ini halaman statis (hanya teks/gambar)
// Tapi kalau footer.php kamu butuh $con, kamu bisa uncomment baris di bawah:
// require "../koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cara Pemesanan – BekasButClassy</title>
<link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../CSS/style.css">
<link rel="stylesheet" href="../fontawesome/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #FFF0F5 0%, #FFCDD2 100%);
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
}
.page-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 40px 16px 60px;
}
.main-card {
    width: 100%;
    max-width: 520px;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 8px 40px rgba(244, 143, 177, 0.18);
    padding: 28px 24px;
    position: relative;
}
.btn-back-styled {
    position: absolute;
    top: 22px; left: 22px;
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #FFF0F5;
    border: 1.5px solid #FFCDD2;
    display: flex; align-items: center; justify-content: center;
    color: #F48FB1; text-decoration: none;
    transition: all 0.25s ease; font-size: 14px;
}
.btn-back-styled:hover { background: #F48FB1; color: white; border-color: #F48FB1; }
.page-header { text-align: center; margin-bottom: 28px; padding-top: 4px; }
.page-header .icon-wrap {
    width: 52px; height: 52px; border-radius: 16px;
    background: linear-gradient(135deg, #FFCDD2, #F48FB1);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px; box-shadow: 0 4px 12px rgba(244, 143, 177, 0.35);
}
.page-header .icon-wrap i { font-size: 22px; color: white; }
.page-header h4 { font-size: 17px; font-weight: 600; color: #212121; margin: 0; }
.page-header p { font-size: 12px; color: #888; margin: 4px 0 0; }

/* Timeline Steps Styling */
.step-list { list-style: none; padding: 0; margin: 0; }
.step-item {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    position: relative;
}
.step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 45px;
    bottom: -20px;
    width: 2px;
    background: #FFCDD2;
    z-index: 0;
}
.step-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FFCDD2, #F48FB1);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 16px;
    flex-shrink: 0;
    z-index: 1;
    box-shadow: 0 4px 10px rgba(244,143,177,0.3);
}
.step-content h5 { font-size: 14px; font-weight: 600; color: #212121; margin: 0 0 4px; }
.step-content p { font-size: 12.5px; color: #666; margin: 0; line-height: 1.6; }

/* Warning / Tips Box */
.tips-box {
    background: #FFFBEB; 
    border-radius: 12px;
    border-left: 3px solid #F59E0B;
    padding: 12px 14px; 
    margin-top: 10px;
    font-size: 12px; 
    color: #92400E; 
    line-height: 1.6;
}

@media (max-width: 480px) {
    .main-card { padding: 22px 16px; }
    .page-wrapper { padding: 24px 12px 48px; }
}
</style>
</head>
<body>
<div class="page-wrapper">
    <div class="main-card">
        <a href="javascript:history.back();" class="btn-back-styled" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        
        <div class="page-header">
            <div class="icon-wrap"><i class="fas fa-shopping-bag"></i></div>
            <h4>Cara Pemesanan</h4>
            <p>Gampang banget! Ikuti 4 langkah di bawah ini</p>
        </div>

        <ul class="step-list">
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-search"></i></div>
                <div class="step-content">
                    <h5>1. Pilih Produk Favoritmu</h5>
                    <p>Jelajahi katalog BekasButClassy. Kalau ada baju yang kamu suka dan masih <strong>Ready</strong>, klik produk tersebut untuk lihat detailnya.</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-cart-plus"></i></div>
                <div class="step-content">
                    <h5>2. Checkout & Isi Data</h5>
                    <p>Klik tombol <strong>"Beli Sekarang"</strong>. Lengkapi nama, nomor HP, dan alamat pengiriman kamu dengan jelas agar kurir tidak bingung.</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-truck"></i></div>
                <div class="step-content">
                    <h5>3. Pilih Kurir & Bayar</h5>
                    <p>Pilih jasa pengiriman (JNE/J&T) dan layanan ongkirnya. Setelah total harga muncul, klik <strong>Checkout</strong> dan lakukan pembayaran sesuai instruksi.</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-box-open"></i></div>
                <div class="step-content">
                    <h5>4. Pesanan Dikirim & Selesai</h5>
                    <p>Setelah pembayaran terverifikasi, admin akan mengemas baju kamu dengan aman. Kamu bisa pantau status dan nomor resi di halaman <strong>Cek Pesanan</strong>.</p>
                </div>
            </li>
        </ul>

        <div class="tips-box">
            💡 <strong>Tips:</strong> Simpan <strong>Kode Pesanan (INV-XXX)</strong> yang muncul setelah checkout. Kamu butuh kode ini untuk mengecek status pengiriman dan melakukan pembayaran!
        </div>

    </div>
</div>
<script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>