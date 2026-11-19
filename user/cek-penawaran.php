<?php
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penawaran – BekasButClassy</title>

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

        .search-group {
            display: flex;
            gap: 8px;
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

        .soft-divider {
            height: 1px;
            background: #FFCDD2;
            margin: 20px 0;
        }
        .inner-divider {
            height: 1px;
            background: #FFCDD2;
        }

        /* TAWAR CARD */
        .tawar-card {
            background: #FFF8FA;
            border-radius: 18px;
            border: 1.5px solid #FFCDD2;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 14px;
            transition: box-shadow 0.2s;
        }
        .tawar-card:last-child { margin-bottom: 0; }
        .tawar-card:hover { box-shadow: 0 4px 18px rgba(244,143,177,0.15); }
        .tawar-card.diterima {
            border-color: #F48FB1;
            background: #fff;
        }

        .tawar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .tawar-nama {
            font-size: 14px;
            font-weight: 600;
            color: #212121;
            margin: 0;
            flex: 1;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .harga-tawaran {
            font-size: 14px;
            font-weight: 600;
            color: #F48FB1;
        }
        .harga-tawaran.ditolak {
            color: #bbb;
            text-decoration: line-through;
            font-weight: 400;
        }

        /* Badge penawaran */
        .badge-pen {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .badge-pen.menunggu { background: #FFF3CD; color: #856404; }
        .badge-pen.diterima { background: #D1E7DD; color: #0A5130; }
        .badge-pen.ditolak  { background: #F8D7DA; color: #721C24; }

        /* Badge status pesanan */
        .badge-ps {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .badge-ps.menunggu-konfirmasi { background: #FFF3CD; color: #856404; }
        .badge-ps.menunggu-pembayaran { background: #CFF4FC; color: #055160; }
        .badge-ps.menunggu-verifikasi { background: #E2E3E5; color: #41464B; }
        .badge-ps.diproses            { background: #CFE2FF; color: #084298; }
        .badge-ps.dikirim             { background: #D1ECF1; color: #0C5460; }
        .badge-ps.selesai             { background: #D1E7DD; color: #0A5130; }
        .badge-ps.dibatalkan          { background: #F8D7DA; color: #721C24; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }
        .info-row .lbl { color: #888; }
        .info-row .val { font-weight: 500; color: #212121; }

        /* Status Message Box */
        .status-box {
            border-radius: 12px;
            padding: 10px 13px;
            font-size: 11.5px;
            line-height: 1.65;
            color: #555;
            border-left: 3px solid #F48FB1;
            background: #FFF0F5;
        }
        .status-box.sb-dikirim  { border-left-color: #0dcaf0; background: #f0faff; }
        .status-box.sb-selesai  { border-left-color: #198754; background: #f0fff4; }
        .status-box.sb-batal    { border-left-color: #dc3545; background: #fff5f5; }

        /* Sub-section pesanan di dalam card diterima */
        .pesanan-section {
            background: #FFF0F5;
            border-radius: 12px;
            border: 1px solid #FFCDD2;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .pesanan-section-title {
            font-size: 10px;
            font-weight: 600;
            color: #F48FB1;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        /* Action Buttons */
        .btn-action {
            display: block;
            width: 100%;
            height: 42px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            text-align: center;
            line-height: 42px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-action.bayar {
            background: #F48FB1;
            color: white;
        }
        .btn-action.bayar:hover { background: #e57da0; color: white; transform: translateY(-1px); }
        .btn-action.alamat {
            background: #fff;
            color: #F48FB1;
            border: 1.5px solid #F48FB1;
            line-height: 39px;
        }
        .btn-action.alamat:hover { background: #FFF0F5; color: #e57da0; }

        /* Alert empty */
        .alert-empty {
            border-radius: 14px;
            background: #fff5f5;
            border: 1.5px dashed #F48FB1;
            padding: 22px;
            text-align: center;
            color: #c9517a;
            font-size: 13px;
        }
        .alert-empty i { font-size: 30px; margin-bottom: 8px; display: block; }

        @media (max-width: 480px) {
            .main-card { padding: 22px 16px; }
            .page-wrapper { padding: 24px 12px 48px; }
        }
    </style>
</head>

<body>
<div class="page-wrapper">
    <div class="main-card">

        <a href="index.php" class="btn-back-styled" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="page-header">
            <div class="icon-wrap">
                <i class="fas fa-tags"></i>
            </div>
            <h4>Cek Penawaran</h4>
            <p>Masukkan No HP yang kamu pakai saat menawar</p>
        </div>

        <form method="GET">
            <div class="search-group">
                <input
                    type="text"
                    name="no_hp"
                    placeholder="Contoh: 081234567890"
                    value="<?= isset($_GET['no_hp']) ? htmlspecialchars($_GET['no_hp']) : '' ?>"
                    required
                >
                <button type="submit" class="btn-cek">Cek</button>
            </div>
        </form>

        <?php
        if (isset($_GET['no_hp'])) {
            $no_hp = mysqli_real_escape_string($con, $_GET['no_hp']);

            /*
             * Query ambil penawaran + join ke pesanan.
             * Ketemu pesanan lewat id_produk + no_hp yang sama,
             * sesuai flow: admin approve penawaran → generate record di tabel pesanan.
             */
            $query = mysqli_query($con, "
                SELECT
                    p.*,
                    pr.nama,
                    ps.kode_pesanan,
                    ps.status_pesanan  AS status_pesanan_real,
                    ps.no_resi
                FROM penawaran p
                JOIN produk pr ON p.id_produk = pr.id
                LEFT JOIN pesanan ps
                    ON ps.id_produk = p.id_produk
                    AND ps.no_hp    = p.no_hp
                WHERE p.no_hp = '$no_hp'
                ORDER BY p.tanggal DESC
                LIMIT 3
            ");

            echo '<div class="soft-divider"></div>';

            if (mysqli_num_rows($query) == 0) {
                echo "
                <div class='alert-empty'>
                    <i class='fas fa-tag'></i>
                    Belum ada penawaran dari nomor HP ini.<br>
                    <small style='color:#aaa; margin-top:6px; display:block;'>Pastikan nomor yang kamu masukkan benar ya!</small>
                </div>
                ";
            } else {
                while ($data = mysqli_fetch_assoc($query)) {

                    $status_pen = $data['status_penawaran'];     // menunggu / diterima / ditolak
                    $stat_pesan = $data['status_pesanan_real'];  // status di tabel pesanan
                    $kode_pesan = $data['kode_pesanan'];

                    $card_class  = 'tawar-card' . ($status_pen == 'diterima' ? ' diterima' : '');
                    $harga_class = 'harga-tawaran' . ($status_pen == 'ditolak' ? ' ditolak' : '');
                    $harga_fmt   = 'Rp ' . number_format($data['harga_tawaran'], 0, ',', '.');

                    echo "<div class='$card_class'>";

                    /* Nama produk + badge status penawaran */
                    echo "<div class='tawar-header'>";
                    echo "  <p class='tawar-nama'>" . htmlspecialchars($data['nama']) . "</p>";
                    echo "  <span class='badge-pen $status_pen'>" . ucfirst($status_pen) . "</span>";
                    echo "</div>";

                    /* Harga tawaran */
                    echo "<div class='info-row'>";
                    echo "  <span class='lbl'>Harga tawaran</span>";
                    echo "  <span class='$harga_class'>$harga_fmt</span>";
                    echo "</div>";

                    /*
                     * ══════════════════════════════════════════
                     * BLOK DITERIMA — tampilkan info + tombol aksi
                     *
                     * FLOW:
                     * 1. status_penawaran = 'diterima'
                     *    → admin sudah approve, record pesanan sudah dibuat
                     *    → kode_pesanan pasti ada
                     *
                     * 2. status_pesanan = 'menunggu_konfirmasi'
                     *    → user belum isi alamat & ongkir
                     *    → tampilkan tombol "Lengkapi Alamat & Ongkir"
                     *    → arahkan ke checkout_lanjutan.php?kode=...
                     *
                     * 3. status_pesanan = 'menunggu_pembayaran'
                     *    → alamat & ongkir sudah diisi, total sudah fix
                     *    → tampilkan tombol "Bayar Sekarang"
                     *    → arahkan ke bayar.php?kode=...
                     *
                     * 4. Status lain (diproses, dikirim, selesai, dibatalkan)
                     *    → hanya tampilkan pesan status, tanpa tombol aksi
                     * ══════════════════════════════════════════
                     */
                    if ($status_pen == 'diterima') {

                        echo "<div class='inner-divider'></div>";

                        if (!empty($kode_pesan)) {

                            /* Sub-section info pesanan */
                            $ps_class = str_replace('_', '-', $stat_pesan);
                            $ps_label = str_replace('_', ' ', $stat_pesan);

                            echo "<div class='pesanan-section'>";
                            echo "  <p class='pesanan-section-title'>Detail Pesanan</p>";

                            echo "  <div class='info-row'>";
                            echo "    <span class='lbl'>Kode Pesanan</span>";
                            echo "    <span class='val' style='color:#F48FB1; font-size:11px;'>" . htmlspecialchars($kode_pesan) . "</span>";
                            echo "  </div>";

                            echo "  <div class='info-row'>";
                            echo "    <span class='lbl'>Status Pesanan</span>";
                            echo "    <span class='badge-ps $ps_class'>$ps_label</span>";
                            echo "  </div>";

                            /* No Resi — hanya tampil kalau sudah dikirim/selesai */
                            if (in_array($stat_pesan, ['dikirim', 'selesai']) && !empty($data['no_resi'])) {
                                echo "  <div class='info-row'>";
                                echo "    <span class='lbl'>No Resi</span>";
                                echo "    <span class='val' style='color:#F48FB1;'>" . htmlspecialchars($data['no_resi']) . "</span>";
                                echo "  </div>";
                            }

                            echo "</div>"; /* /pesanan-section */

                            /* Pesan status */
                            $sb_class = 'status-box';
                            $msg = '';

                            if ($stat_pesan == 'menunggu_konfirmasi') {
                                $msg = "Harga deal! Silakan lengkapi alamat pengiriman dan pilih kurir untuk melihat total ongkir.";
                            } elseif ($stat_pesan == 'menunggu_pembayaran') {
                                $msg = "Alamat sudah tersimpan. Lanjutkan pembayaran di halaman Cek Pesanan ya!";
                            } elseif ($stat_pesan == 'menunggu_verifikasi') {
                                $msg = "⏳ Sistem sedang mengecek pembayaran kamu. Tunggu sebentar ya!";
                            } elseif ($stat_pesan == 'diproses') {
                                $msg = "🎉 Pembayaran berhasil! Paket kamu sedang dikemas dan akan segera dikirim.";
                            } elseif ($stat_pesan == 'dikirim') {
                                $sb_class .= ' sb-dikirim';
                                $msg = "🚚 Paket kamu sedang meluncur! Pantau dengan No Resi di atas.";
                            } elseif ($stat_pesan == 'selesai') {
                                $sb_class .= ' sb-selesai';
                                $msg = "✅ Pesanan selesai. Terima kasih sudah belanja di BekasButClassy!";
                            } elseif ($stat_pesan == 'dibatalkan') {
                                $sb_class .= ' sb-batal';
                                $msg = "❌ Pesanan dari penawaran ini telah dibatalkan.";
                            } else {
                                $msg = "Status: " . htmlspecialchars($stat_pesan);
                            }

                            echo "<div class='$sb_class'>$msg</div>";

                            /* Tombol Aksi */
                            if ($stat_pesan == 'menunggu_konfirmasi') {
                                // Belum isi alamat → ke checkout_lanjutan
                                echo "<a href='checkout_lanjutan.php?kode=" . htmlspecialchars($kode_pesan) . "' class='btn-action alamat'>";
                                echo "  📍 Lengkapi Alamat &amp; Ongkir";
                                echo "</a>";

                            } elseif (in_array($stat_pesan, ['menunggu_pembayaran', 'menunggu_verifikasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])) {
                                // Semua status setelah alamat diisi → arahkan ke cek-pesanan untuk bayar/pantau
                                echo "<a href='cek-pesanan.php?kode=" . htmlspecialchars($kode_pesan) . "' class='btn-action alamat'>";
                                echo "  📦 Lihat Detail Pesanan";
                                echo "</a>";
                            }

                        } else {
                            /*
                             * Penawaran diterima tapi pesanan belum dibuat admin.
                             * Seharusnya jarang terjadi kalau flow admin
                             * otomatis generate kode_pesanan saat approve.
                             */
                            echo "<div class='status-box'>";
                            echo "  🎉 Penawaran kamu diterima! Admin sedang menyiapkan pesanan. ";
                            echo "  Silakan cek kembali beberapa saat lagi.";
                            echo "</div>";
                        }

                    } /* end if diterima */

                    echo "</div>"; /* /tawar-card */
                }
            }
        }
        ?>

    </div>
</div>

<script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
