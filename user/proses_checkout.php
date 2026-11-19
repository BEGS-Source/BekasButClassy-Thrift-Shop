<?php
require "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($con, $_POST['no_hp']);
    
    //  PENGGABUNGAN ALAMAT SUPER LENGKAP V2 
    $alamat_jalan = mysqli_real_escape_string($con, $_POST['alamat_lengkap']);
    $nama_kec = mysqli_real_escape_string($con, $_POST['nama_kecamatan']);
    $nama_kota = mysqli_real_escape_string($con, $_POST['nama_kota']);
    $nama_prov = mysqli_real_escape_string($con, $_POST['nama_provinsi']);
    
    $alamat_final = "$alamat_jalan, Kec. $nama_kec, $nama_kota, Provinsi $nama_prov";
    // Konversi teks dari form ke ID Kurir di tabel database
    $kode_kurir = strtolower($_POST['kurir']);
    $id_kurir = 1; // Default
    if($kode_kurir == 'jne') { $id_kurir = 1; }
    elseif($kode_kurir == 'jnt') { $id_kurir = 2; }
    $ongkir = (int)$_POST['ongkir_final'];

    $no_hp_bersih = preg_replace('/[^0-9+]/', '', $no_hp);
    if (!preg_match('/^(08|628|\+628)[0-9]{7,12}$/', $no_hp_bersih)) {
        echo "<script>alert('Format No HP tidak valid!'); window.history.back();</script>"; exit;
    }

    if($ongkir <= 0){
        echo "<script>alert('Pilih layanan kurir dan ongkos kirim!'); window.history.back();</script>"; exit;
    }

    $cek_stok = mysqli_fetch_assoc(mysqli_query($con, "SELECT ketersediaan_stok FROM produk WHERE id='$id_produk'"));
    if($cek_stok['ketersediaan_stok'] != 'Ready'){
        echo "<script>alert('Produk sudah terjual!'); window.location='index.php';</script>"; exit;
    }

    $kode_pesanan = 'INV-' . strtoupper(substr(md5(uniqid()), 0, 6));
    
    //  FIX TYPO-NYA (CUMA SATU DOLLAR) 
    $produk = mysqli_fetch_assoc(mysqli_query($con, "SELECT harga FROM produk WHERE id='$id_produk'"));
    $harga_baju = (int)$produk['harga']; 
    $total = $harga_baju + $ongkir; //  TOTAL BAYAR ASLI (BAJU + ONGKIR)

    $query = mysqli_query($con, "INSERT INTO pesanan 
    (id_produk, nama_pembeli, no_hp, alamat, id_kurir, ongkir, total_harga, status_pesanan, kode_pesanan) 
    VALUES 
    ('$id_produk','$nama','$no_hp_bersih','$alamat_final','$id_kurir','$ongkir','$total','menunggu_pembayaran','$kode_pesanan')");

    if ($query) {
        mysqli_query($con, "UPDATE produk SET ketersediaan_stok='Reserved' WHERE id='$id_produk'");
        // Lempar balik ke home biar card pop-up nya muncul
        header("Location: index.php?pesan=success&kode=$kode_pesanan");
        exit;
    } else {
        echo "Gagal checkout";
    }
}
?>