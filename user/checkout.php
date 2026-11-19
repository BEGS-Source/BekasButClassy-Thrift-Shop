<?php
require "../koneksi.php";

if (!isset($_GET['id'])) { die("Produk tidak ditemukan"); }

$id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) { die("Produk tidak ditemukan"); }

if ($data['ketersediaan_stok'] != 'Ready') {
    echo "<script>alert('Maaf, produk ini sudah terjual!'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout – BekasButClassy</title>
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #FFF0F5 0%, #FFCDD2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .page-wrapper {
            min-height: 100vh;
            display: flex; align-items: flex-start; justify-content: center;
            padding: 40px 16px 60px;
        }
        .main-card {
            width: 100%; max-width: 580px;
            background: #fff; border-radius: 24px;
            box-shadow: 0 8px 40px rgba(244,143,177,0.18);
            padding: 28px 24px; position: relative;
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
        .page-header { text-align: center; margin-bottom: 20px; padding-top: 4px; }
        .page-header .icon-wrap {
            width: 52px; height: 52px; border-radius: 16px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px; box-shadow: 0 4px 12px rgba(244,143,177,0.35);
        }
        .page-header .icon-wrap i { font-size: 22px; color: white; }
        .page-header h4 { font-size: 17px; font-weight: 600; color: #212121; margin: 0; }
        .page-header p { font-size: 12px; color: #888; margin: 4px 0 0; }

        /* Info produk */
        .info-produk {
            background: #FFF8FA; border-radius: 14px;
            border: 1.5px solid #FFCDD2; padding: 14px 16px;
            margin-bottom: 20px; display: flex; align-items: center; gap: 12px;
        }
        .info-produk .prod-icon {
            width: 48px; height: 48px; border-radius: 13px;
            background: linear-gradient(135deg, #FFCDD2, #F48FB1);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .info-produk .prod-icon i { font-size: 22px; color: white; }
        .prod-name { font-size: 14px; font-weight: 600; color: #212121; margin: 0 0 2px; }
        .prod-harga { font-size: 15px; color: #F48FB1; font-weight: 700; margin: 0; }

        /* Divider */
        .soft-divider { height: 1px; background: #FFCDD2; margin: 18px 0; }

        /* Label */
        .form-label-custom {
            font-size: 12px; font-weight: 500; color: #555;
            margin-bottom: 5px; display: block;
        }

        /* Input & Select */
        .input-custom, .select-custom {
            width: 100%; height: 42px; border-radius: 11px;
            border: 1.5px solid #FFCDD2; padding: 0 12px;
            font-size: 13px; font-family: 'Poppins', sans-serif;
            color: #212121; background: #FFF8FA; outline: none;
            transition: border-color 0.2s; appearance: none;
        }
        .input-custom:focus, .select-custom:focus { border-color: #F48FB1; background: #fff; }
        .input-custom::placeholder { color: #bbb; }
        textarea.input-custom { height: auto; padding: 10px 12px; resize: vertical; }

        /* Total preview */
        .total-preview {
            background: #FFF0F5; border-radius: 12px;
            border: 1.5px dashed #F48FB1; padding: 12px 16px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .total-preview .lbl { font-size: 12px; color: #888; }
        .total-preview .val { font-size: 15px; font-weight: 600; color: #F48FB1; }

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
            <h4>Checkout Produk</h4>
            <p>Lengkapi data pengiriman kamu</p>
        </div>

        <!-- Info Produk -->
        <div class="info-produk">
            <div class="prod-icon"><i class="fas fa-tshirt"></i></div>
            <div>
                <p class="prod-name"><?= htmlspecialchars($data['nama']); ?></p>
                <p class="prod-harga">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
            </div>
        </div>

        <form action="proses_checkout.php" method="POST">
            <input type="hidden" name="id_produk" value="<?= $data['id']; ?>">

            <div class="mb-3">
                <label class="form-label-custom">Nama Pembeli <span style="color:#F48FB1;">*</span></label>
                <input type="text" name="nama" class="input-custom" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">No HP <span style="color:#F48FB1;">*</span></label>
                <input type="text" name="no_hp" class="input-custom" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Alamat Lengkap <span style="color:#F48FB1;">*</span></label>
                <textarea name="alamat_lengkap" class="input-custom" rows="3"
                    placeholder="Contoh: Jl. Mawar No.5, RT 02/RW 03, dekat Alfamart" required></textarea>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label-custom">Provinsi <span style="color:#F48FB1;">*</span></label>
                    <select name="provinsi" id="provinsi" class="select-custom" required>
                        <option value="">-- Memuat... --</option>
                    </select>
                    <input type="hidden" name="nama_provinsi" id="nama_provinsi">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label-custom">Kota/Kabupaten <span style="color:#F48FB1;">*</span></label>
                    <select name="kota" id="kota" class="select-custom" required>
                        <option value="">-- Pilih Kota --</option>
                    </select>
                    <input type="hidden" name="nama_kota" id="nama_kota">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label-custom">Kecamatan <span style="color:#F48FB1;">*</span></label>
                    <select name="kecamatan" id="kecamatan" class="select-custom" required>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                    <input type="hidden" name="nama_kecamatan" id="nama_kecamatan">
                </div>
            </div>

            <div class="soft-divider"></div>

            <div class="mb-3">
                <label class="form-label-custom">Pilih Kurir <span style="color:#F48FB1;">*</span></label>
                <select name="kurir" id="kurir" class="select-custom" required>
                    <option value="">-- Pilih Kurir --</option>
                    <option value="jne">JNE</option>
                    <option value="jnt">J&T</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Layanan & Estimasi Ongkir <span style="color:#F48FB1;">*</span></label>
                <select name="layanan_ongkir" id="layanan_ongkir" class="select-custom" required>
                    <option value="">-- Pilih Kecamatan & Kurir dulu --</option>
                </select>
                <input type="hidden" name="ongkir_final" id="ongkir_final" value="0">
            </div>

            <div class="total-preview mb-3" id="totalPreview" style="display:none;">
                <span class="lbl">Estimasi Total Bayar</span>
                <span class="val" id="totalVal">Rp 0</span>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-lock me-2"></i> Checkout Sekarang
            </button>
            <button type="button" onclick="history.back();" class="btn-back-form">
                Kembali
            </button>

        </form>
    </div>
</div>

<script>
const hargaProduk = <?= (int)$data['harga']; ?>;

$(document).ready(function() {
    $.ajax({
        url: 'api_ongkir.php?action=provinsi',
        success: function(response) {
            let results = JSON.parse(response).data;
            let opts = '<option value="">-- Pilih Provinsi --</option>';
            results.forEach(p => opts += `<option value="${p.id}" nama_prov="${p.name}">${p.name}</option>`);
            $('#provinsi').html(opts);
        }
    });

    $('#provinsi').change(function() {
        $('#nama_provinsi').val($('option:selected', this).attr('nama_prov'));
        let id_prov = $(this).val();
        if (id_prov) {
            $('#kota').html('<option value="">-- Memuat... --</option>');
            $.ajax({
                url: 'api_ongkir.php?action=kota&id_provinsi=' + id_prov,
                success: function(response) {
                    let results = JSON.parse(response).data;
                    let opts = '<option value="">-- Pilih Kota --</option>';
                    results.forEach(k => opts += `<option value="${k.id}" nama_kt="${k.name}">${k.name}</option>`);
                    $('#kota').html(opts);
                    $('#kecamatan').html('<option value="">-- Pilih Kota Dulu --</option>');
                }
            });
        }
    });

    $('#kota').change(function() {
        $('#nama_kota').val($('option:selected', this).attr('nama_kt'));
        let id_kota = $(this).val();
        if (id_kota) {
            $('#kecamatan').html('<option value="">-- Memuat... --</option>');
            $.ajax({
                url: 'api_ongkir.php?action=kecamatan&id_kota=' + id_kota,
                success: function(response) {
                    let results = JSON.parse(response).data;
                    let opts = '<option value="">-- Pilih Kecamatan --</option>';
                    results.forEach(kec => opts += `<option value="${kec.id}" nama_kec="${kec.name}">${kec.name}</option>`);
                    $('#kecamatan').html(opts);
                }
            });
        }
    });

    $('#kecamatan').change(function() {
        $('#nama_kecamatan').val($('option:selected', this).attr('nama_kec'));
        $('#kurir').val('');
        $('#layanan_ongkir').html('<option value="">-- Pilih Kecamatan & Kurir dulu --</option>');
        $('#ongkir_final').val('0');
        $('#totalPreview').hide();
    });

    $('#kurir').change(function() {
        let id_kecamatan = $('#kecamatan').val();
        let kurir = $(this).val();
        if (!id_kecamatan) { alert('Pilih Kecamatan dulu!'); $(this).val(''); return; }
        if (kurir) {
            $('#layanan_ongkir').html('<option value="">-- Menghitung ongkir... --</option>');
            $.ajax({
                url: 'api_ongkir.php?action=cost',
                type: 'POST',
                data: { id_kecamatan: id_kecamatan, kurir: kurir },
                success: function(response) {
                    let data = JSON.parse(response);
                    if (data.meta.code !== 200 || !data.data || data.data.length === 0) {
                        $('#layanan_ongkir').html('<option value="">Kurir tidak tersedia ke alamat ini</option>');
                        $('#ongkir_final').val('0');
                        $('#totalPreview').hide();
                        return;
                    }
                    let opts = '<option value="">-- Pilih Layanan --</option>';
                    data.data.forEach(c => {
                        let est = (!c.etd || c.etd == "") ? "2-3 Hari" : c.etd + " Hari";
                        opts += `<option value="${c.cost}">${c.service} – Rp ${parseInt(c.cost).toLocaleString('id-ID')} (Est. ${est})</option>`;
                    });
                    $('#layanan_ongkir').html(opts);
                }
            });
        }
    });

    $('#layanan_ongkir').change(function() {
        let ongkir = parseInt($(this).val()) || 0;
        $('#ongkir_final').val(ongkir);
        if (ongkir > 0) {
            $('#totalVal').text('Rp ' + (hargaProduk + ongkir).toLocaleString('id-ID'));
            $('#totalPreview').show();
        } else {
            $('#totalPreview').hide();
        }
    });
});
</script>
</body>
</html>
