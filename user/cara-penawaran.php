<?php
// Halaman statis, tidak wajib require koneksi.php kecuali footer butuh
// require "../koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cara Penawaran – BekasButClassy</title>
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

/* Timeline Steps */
.step-list { list-style: none; padding: 0; margin: 0; }
.step-item {
    display: flex; gap: 16px; margin-bottom: 24px; position: relative;
}
.step-item:not(:last-child)::after {
    content: ''; position: absolute; left: 19px; top: 45px; bottom: -20px;
    width: 2px; background: #FFCDD2; z-index: 0;
}
.step-icon {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, #FFCDD2, #F48FB1);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 16px; flex-shrink: 0; z-index: 1;
    box-shadow: 0 4px 10px rgba(244,143,177,0.3);
}
.step-content h5 { font-size: 14px; font-weight: 600; color: #212121; margin: 0 0 4px; }
.step-content p { font-size: 12.5px; color: #666; margin: 0; line-height: 1.6; }

/* Rules Box */
.rules-box {
    background: #FFF0F5; 
    border-radius: 12px;
    border: 1.5px dashed #F48FB1;
    padding: 14px 16px; 
    margin-top: 12px;
}
.rules-box h6 { font-size: 13px; font-weight: 600; color: #F48FB1; margin-bottom: 8px; }
.rules-box ul { padding-left: 18px; margin: 0; font-size: 12px; color: #555; line-height: 1.7; }
.rules-box ul li { margin-bottom: 4px; }

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
            <div class="icon-wrap"><i class="fas fa-gavel"></i></div>
            <h4>Cara Melakukan Penawaran</h4>
            <p>Sistem nego asik & transparan dari BekasButClassy</p>
        </div>

        <ul class="step-list">
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-tags"></i></div>
                <div class="step-content">
                    <h5>1. Klik Tombol "Ajukan Penawaran"</h5>
                    <p>Di halaman detail produk, jika kamu merasa harganya belum pas di hati, klik tombol <strong>Ajukan Penawaran</strong>.</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-edit"></i></div>
                <div class="step-content">
                    <h5>2. Isi Data & Nominal Wajar</h5>
                    <p>Masukkan Nama, No HP (aktif/WhatsApp), dan harga tawaranmu. <strong>Tips:</strong> Tawar dengan harga masuk akal ya, jangan terlalu rendah agar peluang diterima lebih besar!</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-search"></i></div>
                <div class="step-content">
                    <h5>3. Cek Status di "Cek Penawaran"</h5>
                    <p>Admin akan meninjau tawaranmu. Kamu bisa pantau statusnya (Diterima/Ditolak/Menunggu) di menu <strong>Cek Penawaran</strong> menggunakan No HP yang sama.</p>
                </div>
            </li>
            <li class="step-item">
                <div class="step-icon"><i class="fas fa-handshake"></i></div>
                <div class="step-content">
                    <h5>4. Deal? Langsung Checkout!</h5>
                    <p>Jika statusnya <strong>"Diterima"</strong>, kamu akan langsung diarahkan untuk melengkapi alamat dan bayar dengan harga yang sudah disepakati (Deal).</p>
                </div>
            </li>
        </ul>

        <div class="rules-box">
            <h6><i class="fas fa-info-circle me-1"></i> Aturan Main (Penting!)</h6>
            <ul>
                <li><strong>Limit Harian:</strong> Maksimal 3x penawaran per hari untuk produk yang sama.</li>
                <li><strong>Revisi Harga:</strong> Salah ketik atau mau nawar lagi? Kirim saja tawaran baru selama status masih <em>"Menunggu"</em>, sistem otomatis mengupdate harga tawaranmu.</li>
                <li><strong>No Spam:</strong> Penawaran tidak wajar (misal: baju 100rb ditawar 10rb) akan langsung ditolak sistem/admin.</li>
            </ul>
        </div>

    </div>
</div>
<script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>