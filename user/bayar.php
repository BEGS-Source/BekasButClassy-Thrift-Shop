<?php
require "../koneksi.php";

if (!isset($_GET['kode'])) {
    die("Kode pesanan tidak ditemukan.");
}

$kode = mysqli_real_escape_string($con, $_GET['kode']);

$query = mysqli_query($con, "
    SELECT ps.*, pr.nama as nama_produk, kr.nama_kurir
    FROM pesanan ps 
    JOIN produk pr ON ps.id_produk = pr.id
    LEFT JOIN kurir kr ON ps.id_kurir = kr.id_kurir
    WHERE ps.kode_pesanan='$kode'
");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Pesanan tidak ditemukan.");
}

$snap_token = $data['snap_token'];

// Kalau token belum ada, minta ke Midtrans
if (empty($snap_token)) {

    $serverKey = MIDTRANS_SERVER_KEY;

    $transaction_data = array(
        'transaction_details' => array(
            'order_id'     => $kode,
            'gross_amount' => (int)$data['total_harga'],
        ),
        'customer_details' => array(
            'first_name' => $data['nama_pembeli'],
            'phone'      => $data['no_hp'],
        )
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL            => "https://app.sandbox.midtrans.com/snap/v1/transactions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => json_encode($transaction_data),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_HTTPHEADER     => array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Basic " . base64_encode($serverKey . ":")
        ),
    ));

    $response      = curl_exec($curl);
    curl_close($curl);
    $json_response = json_decode($response);
    $snap_token    = $json_response->token ?? '';

    if (!empty($snap_token)) {
        mysqli_query($con, "UPDATE pesanan SET snap_token='$snap_token' WHERE kode_pesanan='$kode'");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran – BekasButClassy</title>

    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= MIDTRANS_CLIENT_KEY ?>"></script>

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
            max-width: 480px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(244,143,177,0.18);
            padding: 28px 24px;
            position: relative;
        }

        /* Back button */
        .btn-back-styled {
            position: absolute;
            top: 22px; left: 22px;
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #FFF0F5;
            border: 1.5px solid #FFCDD2;
            display: flex; align-items: center; justify-content: center;
            color: #F48FB1;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.25s;
        }
        .btn-back-styled:hover { background: #F48FB1; color: white; border-color: #F48FB1; }

        /* Header */
        .page-header { text-align: center; margin-bottom: 22px; padding-top: 4px; }
        .page-header .icon-wrap {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 4px 12px rgba(244,143,177,0.35);
        }
        .page-header .icon-wrap i { font-size: 22px; color: white; }
        .page-header h4 { font-size: 17px; font-weight: 600; color: #212121; margin: 0; }
        .page-header p { font-size: 12px; color: #888; margin: 4px 0 0; }

        /* Step bar */
        .step-bar {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; margin-bottom: 22px;
        }
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600;
        }
        .step-dot.done   { background: #D1E7DD; color: #0A5130; }
        .step-dot.active { background: #F48FB1; color: white; }
        .step-line { flex: 1; max-width: 40px; height: 2px; background: #FFCDD2; border-radius: 2px; }

        /* Ringkasan pesanan */
        .order-summary {
            background: #FFF8FA;
            border-radius: 16px;
            border: 1.5px solid #FFCDD2;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .prod-row {
            display: flex; align-items: center; gap: 12px;
        }
        .prod-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .prod-icon i { font-size: 20px; color: white; }
        .prod-meta .prod-name { font-size: 14px; font-weight: 600; color: #212121; margin: 0 0 2px; }
        .prod-meta .prod-kode { font-size: 11px; color: #888; margin: 0; }

        .soft-divider { height: 1px; background: #FFCDD2; }

        .info-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 12px;
        }
        .info-row .lbl { color: #888; }
        .info-row .val { font-weight: 500; color: #212121; }
        .info-row .val.pink { color: #F48FB1; font-weight: 600; }

        .badge-kurir {
            display: inline-block;
            background: #F48FB1;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Total box */
        .total-box {
            background: #FFF0F5;
            border-radius: 12px;
            border: 1.5px dashed #F48FB1;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .total-box .lbl { font-size: 13px; color: #888; font-weight: 500; }
        .total-box .val { font-size: 20px; font-weight: 700; color: #F48FB1; }

        /* Pay button */
        .btn-pay {
            width: 100%;
            height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #F48FB1, #e57da0);
            color: white;
            border: none;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(244,143,177,0.4);
            letter-spacing: 0.3px;
        }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(244,143,177,0.5); }
        .btn-pay:active { transform: translateY(0); }

        .btn-back-link {
            display: block;
            width: 100%;
            height: 42px;
            border-radius: 12px;
            border: 1.5px solid #FFCDD2;
            background: #FFF8FA;
            color: #888;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            text-align: center;
            line-height: 40px;
            margin-top: 10px;
            transition: all 0.2s;
        }
        .btn-back-link:hover { background: #FFCDD2; color: #555; }

        /* Secure note */
        .secure-note {
            text-align: center;
            font-size: 11px;
            color: #bbb;
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .secure-note i { font-size: 12px; color: #F48FB1; }

        /* Token error */
        .token-error {
            background: #fff5f5;
            border: 1.5px solid #FFCDD2;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            font-size: 13px;
            color: #c9517a;
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

        <a href="cek-pesanan.php?kode=<?= $kode ?>" class="btn-back-styled" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- Header -->
        <div class="page-header">
            <div class="icon-wrap"><i class="fas fa-credit-card"></i></div>
            <h4>Selesaikan Pembayaran</h4>
            <p>Pilih metode pembayaran yang kamu inginkan</p>
        </div>

        <!-- Step bar -->
        <div class="step-bar">
            <div class="step-dot done"><i class="fas fa-check" style="font-size:10px;"></i></div>
            <div class="step-line"></div>
            <div class="step-dot done"><i class="fas fa-check" style="font-size:10px;"></i></div>
            <div class="step-line"></div>
            <div class="step-dot active">3</div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="order-summary">

            <div class="prod-row">
                <div class="prod-icon"><i class="fas fa-tshirt"></i></div>
                <div class="prod-meta">
                    <p class="prod-name"><?= htmlspecialchars($data['nama_produk']); ?></p>
                    <p class="prod-kode">Kode: <?= htmlspecialchars($data['kode_pesanan']); ?></p>
                </div>
            </div>

            <div class="soft-divider"></div>

            <div class="info-row">
                <span class="lbl">Nama Pembeli</span>
                <span class="val"><?= htmlspecialchars($data['nama_pembeli']); ?></span>
            </div>
            <div class="info-row">
                <span class="lbl">No HP</span>
                <span class="val"><?= htmlspecialchars($data['no_hp']); ?></span>
            </div>
            <div class="info-row">
                <span class="lbl">Kurir</span>
                <span class="val">
                    <span class="badge-kurir"><?= htmlspecialchars($data['nama_kurir'] ?? '-'); ?></span>
                </span>
            </div>
            <div class="info-row">
                <span class="lbl">Ongkos Kirim</span>
                <span class="val">Rp <?= number_format($data['ongkir'], 0, ',', '.'); ?></span>
            </div>

        </div>

        <!-- Total -->
        <div class="total-box">
            <span class="lbl">Total Pembayaran</span>
            <span class="val">Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></span>
        </div>

        <?php if (!empty($snap_token)): ?>
            <!-- Tombol Bayar -->
            <button id="pay-button" class="btn-pay">
                <i class="fas fa-lock me-2"></i> PILIH METODE PEMBAYARAN
            </button>
            <a href="cek-pesanan.php?kode=<?= $kode ?>" class="btn-back-link">
                Kembali ke Detail Pesanan
            </a>
        <?php else: ?>
            <div class="token-error">
                <i class="fas fa-exclamation-triangle mb-2" style="font-size:24px; display:block;"></i>
                Gagal memuat metode pembayaran.<br>
                <small style="color:#aaa;">Silakan refresh halaman atau hubungi admin.</small>
            </div>
        <?php endif; ?>

        <div class="secure-note">
            <i class="fas fa-shield-alt"></i>
            Pembayaran diamankan oleh Midtrans
        </div>

    </div>
</div>

<script>
    <?php if (!empty($snap_token)): ?>
    document.getElementById('pay-button').onclick = function() {
        snap.pay('<?= $snap_token ?>', {
            onSuccess: function(result) {
                window.location.href = "cek-pesanan.php?kode=<?= $kode ?>";
            },
            onPending: function(result) {
                window.location.href = "cek-pesanan.php?kode=<?= $kode ?>";
            },
            onError: function(result) {
                alert("Pembayaran gagal. Silakan coba lagi.");
            },
            onClose: function() {
                // User tutup popup, tidak ada aksi
            }
        });
    };
    <?php endif; ?>
</script>
</body>
</html>
