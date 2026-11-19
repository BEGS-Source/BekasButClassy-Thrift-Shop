<?php
require "../koneksi.php";

if (!isset($_GET['id'])) { die("Produk tidak ditemukan"); }
$id_produk = $_GET['id'];

// Ambil data produk biar bisa tampilkan nama & harga
$data_produk = mysqli_fetch_assoc(mysqli_query($con, "SELECT nama, harga FROM produk WHERE id='$id_produk'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Penawaran – BekasButClassy</title>

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
            display: flex; align-items: center; justify-content: center;
            padding: 40px 16px;
        }
        .main-card {
            width: 100%; max-width: 440px;
            background: #fff; border-radius: 24px;
            box-shadow: 0 8px 40px rgba(244,143,177,0.18);
            padding: 32px 28px; position: relative;
        }
        .btn-back-styled {
            position: absolute; top: 22px; left: 22px;
            width: 36px; height: 36px; border-radius: 50%;
            background: #FFF0F5; border: 1.5px solid #FFCDD2;
            display: flex; align-items: center; justify-content: center;
            color: #F48FB1; text-decoration: none; font-size: 14px;
            transition: all 0.25s;
        }
        .btn-back-styled:hover { background: #F48FB1; color: white; border-color: #F48FB1; }

        /* Header */
        .page-header { text-align: center; margin-bottom: 22px; padding-top: 4px; }
        .page-header .icon-wrap {
            width: 56px; height: 56px; border-radius: 18px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; box-shadow: 0 4px 14px rgba(244,143,177,0.35);
        }
        .page-header .icon-wrap i { font-size: 24px; color: white; }
        .page-header h4 { font-size: 18px; font-weight: 600; color: #212121; margin: 0; }
        .page-header p { font-size: 12px; color: #888; margin: 4px 0 0; }

        /* Info produk */
        .info-produk {
            background: #FFF8FA; border-radius: 14px;
            border: 1.5px solid #FFCDD2; padding: 12px 16px;
            margin-bottom: 22px; display: flex; align-items: center; gap: 12px;
        }
        .info-produk .prod-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .info-produk .prod-icon i { font-size: 20px; color: white; }
        .prod-name { font-size: 13px; font-weight: 600; color: #212121; margin: 0 0 2px; }
        .prod-harga { font-size: 13px; color: #F48FB1; font-weight: 600; margin: 0; }
        .prod-sub { font-size: 11px; color: #888; margin: 0; }

        /* Warning box */
        .warn-box {
            background: #FFFBEB; border-radius: 12px;
            border-left: 3px solid #F59E0B;
            padding: 10px 13px; margin-bottom: 20px;
            font-size: 11.5px; color: #92400E; line-height: 1.6;
        }

        /* Label */
        .form-label-custom {
            font-size: 12px; font-weight: 500; color: #555;
            margin-bottom: 5px; display: block;
        }

        /* Input */
        .input-custom {
            width: 100%; height: 42px; border-radius: 11px;
            border: 1.5px solid #FFCDD2; padding: 0 12px;
            font-size: 13px; font-family: 'Poppins', sans-serif;
            color: #212121; background: #FFF8FA; outline: none;
            transition: border-color 0.2s;
        }
        .input-custom:focus { border-color: #F48FB1; background: #fff; }
        .input-custom::placeholder { color: #bbb; }

        /* Buttons */
        .btn-submit {
            width: 100%; height: 46px; border-radius: 13px;
            background: linear-gradient(135deg, #F48FB1, #e57da0);
            color: white; border: none; font-size: 14px; font-weight: 600;
            font-family: 'Poppins', sans-serif; cursor: pointer;
            box-shadow: 0 4px 14px rgba(244,143,177,0.4);
            transition: all 0.2s; margin-top: 6px;
        }
        .btn-submit:hover { transform: translateY(-1px); }
        .btn-back-form {
            width: 100%; height: 42px; border-radius: 12px;
            background: #FFF8FA; color: #888;
            border: 1.5px solid #FFCDD2; font-size: 13px; font-weight: 500;
            font-family: 'Poppins', sans-serif; cursor: pointer;
            transition: all 0.2s; margin-top: 8px;
        }
        .btn-back-form:hover { background: #FFCDD2; color: #555; }

        @media (max-width: 480px) {
            .main-card { padding: 24px 18px; }
            .page-wrapper { padding: 24px 12px; }
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
            <div class="icon-wrap"><i class="fas fa-tags"></i></div>
            <h4>Ajukan Penawaran</h4>
            <p>Masukkan harga terbaikmu</p>
        </div>

        <!-- Info Produk -->
        <?php if ($data_produk): ?>
        <div class="info-produk">
            <div class="prod-icon"><i class="fas fa-tshirt"></i></div>
            <div>
                <p class="prod-name"><?= htmlspecialchars($data_produk['nama']); ?></p>
                <p class="prod-sub">Harga awal</p>
                <p class="prod-harga">Rp <?= number_format($data_produk['harga'], 0, ',', '.'); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Warning -->
        <div class="warn-box">
            ⚠️ <strong>Heads up!</strong> Jangan nawar terlalu rendah ya — penawaran yang tidak wajar langsung ditolak!
        </div>

        <form action="proses_penawaran.php" method="POST">
            <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">

            <div class="mb-3">
                <label class="form-label-custom">Nama <span style="color:#F48FB1;">*</span></label>
                <input type="text" name="nama" class="input-custom" placeholder="Masukkan nama kamu" required>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">No HP <span style="color:#F48FB1;">*</span></label>
                <input type="text" name="no_hp" class="input-custom" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Harga Tawaran <span style="color:#F48FB1;">*</span></label>
                <input type="text" name="harga" id="harga" class="input-custom"
                    placeholder="Contoh: 50.000" required>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane me-2"></i> Kirim Penawaran
            </button>
            <button type="button" onclick="history.back();" class="btn-back-form">
                Kembali
            </button>
        </form>

    </div>
</div>

<script>
    // Format harga otomatis saat mengetik
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = new Intl.NumberFormat('id-ID').format(value);
    });
</script>
</body>
</html>
