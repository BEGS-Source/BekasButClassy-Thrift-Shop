<?php
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pesanan – BekasButClassy</title>

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

        /* Back Button */
        .btn-back-styled {
            position: absolute;
            top: 22px;
            left: 22px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #FFF0F5;
            border: 1.5px solid #FFCDD2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F48FB1;
            text-decoration: none;
            transition: all 0.25s ease;
            font-size: 14px;
        }
        .btn-back-styled:hover {
            background: #F48FB1;
            color: white;
            border-color: #F48FB1;
        }

        /* Header */
        .page-header {
            text-align: center;
            margin-bottom: 22px;
            padding-top: 4px;
        }
        .page-header .icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 4px 12px rgba(244, 143, 177, 0.35);
        }
        .page-header .icon-wrap i { font-size: 22px; color: white; }
        .page-header h4 {
            font-size: 17px;
            font-weight: 600;
            color: #212121;
            margin: 0;
        }
        .page-header p {
            font-size: 12px;
            color: #888;
            margin: 4px 0 0;
        }

        /* Search */
        .search-group {
            display: flex;
            gap: 8px;
            margin-bottom: 6px;
        }
        .search-group input {
            flex: 1;
            height: 44px;
            border-radius: 12px;
            border: 1.5px solid #FFCDD2;
            padding: 0 14px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #212121;
            background: #FFF8FA;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-group input:focus {
            border-color: #F48FB1;
            background: #fff;
        }
        .search-group input::placeholder { color: #bbb; }
        .btn-cek {
            height: 44px;
            padding: 0 20px;
            border-radius: 12px;
            background: #F48FB1;
            color: white;
            border: none;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-cek:hover { background: #e57da0; transform: translateY(-1px); }
        .btn-cek:active { transform: translateY(0); }

        /* Divider */
        .soft-divider {
            height: 1px;
            background: #FFCDD2;
            margin: 20px 0;
            border-radius: 2px;
        }

        /* Result Card */
        .result-card {
            background: #FFF8FA;
            border-radius: 18px;
            border: 1.5px solid #FFCDD2;
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Product Row */
        .product-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .product-icon {
            width: 50px; height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .product-icon i { font-size: 22px; color: white; }
        .product-meta h5 {
            font-size: 14px;
            font-weight: 600;
            color: #212121;
            margin: 0 0 2px;
        }
        .product-meta p {
            font-size: 11px;
            color: #888;
            margin: 0;
        }

        /* Info rows */
        .info-table { width: 100%; }
        .info-table tr td {
            font-size: 12px;
            padding: 5px 0;
            vertical-align: middle;
        }
        .info-table tr td:first-child { color: #888; width: 40%; }
        .info-table tr td:last-child {
            font-weight: 500;
            color: #212121;
            text-align: right;
        }
        .harga-total {
            font-size: 16px !important;
            color: #F48FB1 !important;
            font-weight: 600 !important;
        }
        .resi-val { color: #F48FB1 !important; font-weight: 600 !important; }

        /* Badge Status */
        .status-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }
        .badge-menunggu-konfirmasi { background: #FFF3CD; color: #856404; }
        .badge-menunggu-pembayaran { background: #CFF4FC; color: #055160; }
        .badge-menunggu-verifikasi { background: #E2E3E5; color: #41464B; }
        .badge-diproses { background: #CFE2FF; color: #084298; }
        .badge-dikirim { background: #D1ECF1; color: #0C5460; }
        .badge-selesai { background: #D1E7DD; color: #0A5130; }
        .badge-dibatalkan { background: #F8D7DA; color: #721C24; }
        .badge-kurir { background: #F48FB1; color: white; }

        /* Status Box */
        .status-box {
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 12px;
            line-height: 1.6;
            border-left: 3px solid #F48FB1;
            background: #FFF0F5;
            color: #555;
        }
        .status-box.status-dibatalkan { border-left-color: #dc3545; background: #fff5f5; }
        .status-box.status-selesai { border-left-color: #198754; background: #f0fff4; }
        .status-box.status-dikirim { border-left-color: #0dcaf0; background: #f0faff; }

        /* Action Buttons */
        .btn-bayar-now {
            display: block;
            width: 100%;
            height: 44px;
            border-radius: 12px;
            background: #F48FB1;
            color: white;
            border: none;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            text-align: center;
            line-height: 44px;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-bayar-now:hover { background: #e57da0; color: white; transform: translateY(-1px); }

        .btn-refresh-now {
            display: block;
            width: 100%;
            height: 40px;
            border-radius: 12px;
            background: #FFF0F5;
            color: #F48FB1;
            border: 1.5px solid #FFCDD2;
            font-size: 12px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            text-align: center;
            line-height: 38px;
            transition: all 0.2s;
            margin-top: 8px;
        }
        .btn-refresh-now:hover { background: #FFCDD2; color: #c9517a; }

        /* Alert not found */
        .alert-notfound {
            border-radius: 14px;
            background: #fff5f5;
            border: 1.5px dashed #F48FB1;
            padding: 18px;
            text-align: center;
            color: #c9517a;
            font-size: 13px;
        }
        .alert-notfound i { font-size: 28px; margin-bottom: 8px; display: block; }

        /* Responsive */
        @media (max-width: 480px) {
            .main-card { padding: 22px 16px; }
            .page-wrapper { padding: 24px 12px 48px; }
        }
    </style>
</head>

<body>
<div class="page-wrapper">
    <div class="main-card">

        <!-- Back Button -->
        <a href="index.php" class="btn-back-styled" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- Header -->
        <div class="page-header">
            <div class="icon-wrap">
                <i class="fas fa-box"></i>
            </div>
            <h4>Cek Pesanan</h4>
            <p>Masukkan kode pesanan kamu di bawah ini</p>
        </div>

        <!-- Form Search -->
        <form method="GET">
            <div class="search-group">
                <input
                    type="text"
                    name="kode"
                    placeholder="Contoh: INV-ABC123"
                    value="<?= isset($_GET['kode']) ? htmlspecialchars($_GET['kode']) : '' ?>"
                    required
                >
                <button type="submit" class="btn-cek">Cek</button>
            </div>
        </form>

        <?php
        if (isset($_GET['kode'])) {
            $kode = mysqli_real_escape_string($con, $_GET['kode']);

            $query = mysqli_query($con, "
                SELECT p.*, pr.nama, kr.nama_kurir
                FROM pesanan p
                JOIN produk pr ON p.id_produk = pr.id
                LEFT JOIN kurir kr ON p.id_kurir = kr.id_kurir
                WHERE p.kode_pesanan='$kode'
            ");

            $data = mysqli_fetch_assoc($query);

            if ($data) {
                $status = $data['status_pesanan'];

                // Map badge class
                $badge_class = 'badge-' . str_replace('_', '-', $status);
                $badge_label = str_replace('_', ' ', $status);
        ?>

        <div class="soft-divider"></div>

        <div class="result-card">

            <!-- Produk -->
            <div class="product-row">
                <div class="product-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <div class="product-meta">
                    <h5><?= htmlspecialchars($data['nama']); ?></h5>
                    <p>Kode: <strong><?= htmlspecialchars($data['kode_pesanan']); ?></strong></p>
                </div>
            </div>

            <div class="soft-divider" style="margin: 4px 0;"></div>

            <!-- Info Detail -->
            <table class="info-table">
                <tr>
                    <td>Nama Pembeli</td>
                    <td><?= htmlspecialchars($data['nama_pembeli']); ?></td>
                </tr>
                <tr>
                    <td>No HP</td>
                    <td><?= htmlspecialchars($data['no_hp']); ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= htmlspecialchars($data['alamat']); ?></td>
                </tr>
                <tr>
                    <td>Kurir</td>
                    <td>
                        <span class="status-badge badge-kurir">
                            <?= htmlspecialchars($data['nama_kurir'] ?? '-'); ?>
                        </span>
                    </td>
                </tr>
                <?php if ($status == 'dikirim' || $status == 'selesai') { ?>
                <tr>
                    <td>No Resi</td>
                    <td class="resi-val"><?= htmlspecialchars($data['no_resi'] ?? '-'); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Total Bayar</td>
                    <td class="harga-total">Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <span class="status-badge <?= $badge_class; ?>">
                            <?= $badge_label; ?>
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Status Message Box -->
            <?php
                $box_class = 'status-box';
                $msg = '';
                if ($status == 'menunggu_konfirmasi' || $status == 'menunggu_pembayaran') {
                    $msg = "Totalan sudah tersedia! Klik tombol di bawah untuk melakukan pembayaran via Midtrans.";
                } elseif ($status == 'menunggu_verifikasi') {
                    $msg = "⏳ Pembayaran sedang diproses oleh sistem Midtrans. Jika kamu sudah bayar, status akan otomatis berubah.";
                } elseif ($status == 'diproses') {
                    $msg = "🎉 Pembayaran berhasil diverifikasi! Paket kamu sedang dikemas dengan aman dan akan segera dikirim.";
                } elseif ($status == 'dikirim') {
                    $msg = "🚚 Paket kamu sedang meluncur! Pantau perjalanannya dengan No Resi di atas.";
                    $box_class .= ' status-dikirim';
                } elseif ($status == 'selesai') {
                    $msg = "✅ Pesanan selesai. Terima kasih sudah belanja di BekasButClassy!";
                    $box_class .= ' status-selesai';
                } elseif ($status == 'dibatalkan') {
                    $msg = "❌ Pesanan ini telah dibatalkan atau waktu pembayaran habis.";
                    $box_class .= ' status-dibatalkan';
                }

                if ($msg) {
                    echo "<div class='$box_class'>$msg</div>";
                }
            ?>

            <!-- Action Buttons -->
            <?php if ($status == 'menunggu_konfirmasi' || $status == 'menunggu_pembayaran') { ?>
                <a href="bayar.php?kode=<?= $data['kode_pesanan']; ?>" class="btn-bayar-now">
                    💳 Bayar Sekarang
                </a>
                <a href="cek-status.php?kode=<?= $data['kode_pesanan']; ?>" class="btn-refresh-now">
                    🔄 Refresh Status Pembayaran
                </a>
            <?php } ?>

        </div><!-- /result-card -->

        <?php
            } else {
        ?>
        <div class="soft-divider"></div>
        <div class="alert-notfound">
            <i class="fas fa-box-open"></i>
            Pesanan dengan kode <strong>"<?= htmlspecialchars($kode); ?>"</strong> tidak ditemukan.<br>
            <small style="color:#aaa; margin-top:6px; display:block;">Pastikan kode yang kamu masukkan benar ya!</small>
        </div>
        <?php
            }
        }
        ?>

    </div><!-- /main-card -->
</div><!-- /page-wrapper -->

<script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
