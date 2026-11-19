<?php
require "../koneksi.php";

// 1. Ambil data JSON yang dikirim otomatis sama Midtrans
$json_result = file_get_contents('php://input');
$result = json_decode($json_result, true);

if (!$result) {
    die("Tidak ada data dari Midtrans.");
}

// 2. Amankan input biar nggak kena SQL Injection
$order_id = mysqli_real_escape_string($con, $result['order_id']);
$status_code = $result['status_code'];
$transaction_status = $result['transaction_status'];
$gross_amount = $result['gross_amount']; // Butuh total harga buat cek signature
$received_signature = $result['signature_key'];


$server_key = MIDTRANS_SERVER_KEY;
$my_signature = hash("sha512", $order_id . $status_code . $gross_amount . $server_key);

if ($my_signature !== $received_signature) {
    die("Akses ditolak: Signature tidak valid!");
}

// 4. Logika update status di database
if ($status_code == '200') {
    if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        // PEMBAYARAN BERHASIL/LUNAS
        mysqli_query($con, "UPDATE pesanan SET status_pesanan='diproses' WHERE kode_pesanan='$order_id'");
        
        // Update status produk jadi 'Sold'
        $query_pesanan = mysqli_query($con, "SELECT id_produk FROM pesanan WHERE kode_pesanan='$order_id'");
        if ($data_p = mysqli_fetch_assoc($query_pesanan)) {
            $id_produk = mysqli_real_escape_string($con, $data_p['id_produk']);
            mysqli_query($con, "UPDATE produk SET ketersediaan_stok='Sold' WHERE id='$id_produk'");
        }

    } elseif ($transaction_status == 'pending') {
        // User dapet kode bayar tapi belum transfer
        mysqli_query($con, "UPDATE pesanan SET status_pesanan='menunggu_pembayaran' WHERE kode_pesanan='$order_id'");

    } elseif ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
        // Pembayaran gagal atau expired (Lewat dari 24 Jam)
        mysqli_query($con, "UPDATE pesanan SET status_pesanan='dibatalkan' WHERE kode_pesanan='$order_id'");
        
        // Balikin stok produk jadi 'Ready'
        $query_pesanan = mysqli_query($con, "SELECT id_produk FROM pesanan WHERE kode_pesanan='$order_id'");
        if ($data_p = mysqli_fetch_assoc($query_pesanan)) {
            $id_produk = mysqli_real_escape_string($con, $data_p['id_produk']);
            mysqli_query($con, "UPDATE produk SET ketersediaan_stok='Ready' WHERE id='$id_produk'");
        }
    }
}
?>