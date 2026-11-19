<?php
require "../koneksi.php";

if (!isset($_GET['kode'])) {
    die("Kode pesanan tidak ditemukan.");
}

$kode = mysqli_real_escape_string($con, $_GET['kode']);
$server_key = MIDTRANS_SERVER_KEY; // Server Key 

//  INI YANG DIBENERIN: URL API V2 MIDTRANS 
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/" . $kode . "/status",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false, // Anti blokir Localhost
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Basic " . base64_encode($serverKey . ":")
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "<script>alert('Gagal cek status: " . $err . "'); window.history.back();</script>";
    exit;
}

$result = json_decode($response, true);

// LOGIKA UPDATE DATABASE BERDASARKAN JAWABAN MIDTRANS
if (isset($result['transaction_status'])) {
    $stat = $result['transaction_status'];
    
    if ($stat == 'settlement' || $stat == 'capture') {
        // LUNAS! Update status pesanan
        mysqli_query($con, "UPDATE pesanan SET status_pesanan='diproses' WHERE kode_pesanan='$kode'");
        
        // Update stok produk jadi Sold
        $q_p = mysqli_fetch_assoc(mysqli_query($con, "SELECT id_produk FROM pesanan WHERE kode_pesanan='$kode'"));
        $id_p = $q_p['id_produk'];
        mysqli_query($con, "UPDATE produk SET ketersediaan_stok='Sold' WHERE id='$id_p'");
        
        echo "<script>alert('Pembayaran Berhasil Terverifikasi!'); window.location='cek-pesanan.php?kode=$kode';</script>";
    } else if ($stat == 'pending') {
        echo "<script>alert('Pesanan belum dibayar. Segera selesaikan pembayaran ya!'); window.history.back();</script>";
    } else {
        echo "<script>alert('Status: " . $stat . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Data transaksi belum ada di Midtrans. Pastikan Anda sudah checkout.'); window.history.back();</script>";
}
?>