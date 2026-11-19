<?php
require "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_produk = $_POST['id_produk'];
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($con, $_POST['no_hp']);
    $harga_input = $_POST['harga'];

    //  KUNCI KEAMANAN: Validasi Nomor HP 
    $no_hp_bersih = preg_replace('/[^0-9+]/', '', $no_hp);
    if (!preg_match('/^(08|628|\+628)[0-9]{7,12}$/', $no_hp_bersih)) {
        echo "<script>
            alert('Format No HP tidak valid! Harap gunakan awalan 08, 628, atau +628 dengan panjang angka yang benar.');
            window.history.back();
        </script>";
        exit;
    }
    $no_hp_final = $no_hp_bersih;

    // Hapus titik & koma biar jadi angka murni
    $harga = str_replace(['.', ','], '', $harga_input);

    //  KUNCI KEAMANAN BARU: Pastikan inputan murni angka dan tidak 0
    if (!is_numeric($harga) || $harga <= 0) {
        echo "<script>
            alert('Format harga salah! Harap masukkan nominal angka yang benar (contoh: 50000).');
            window.history.back();
        </script>";
        exit;
    }

    //  KUNCI KEAMANAN STOK: Pastikan barang masih Ready sebelum ditawar
    $cek_stok = mysqli_fetch_assoc(mysqli_query($con, "SELECT ketersediaan_stok FROM produk WHERE id='$id_produk'"));
    if($cek_stok['ketersediaan_stok'] != 'Ready'){
        echo "<script>
            alert('Maaf, barang ini sudah " . $cek_stok['ketersediaan_stok'] . " dan tidak bisa ditawar lagi!');
            window.location='index.php';
        </script>";
        exit;
    }

    
    //  FITUR REVISI TAWARAN: Jika masih 'menunggu', update harganya saja
    $cek_pending = mysqli_query($con, "
        SELECT id 
        FROM penawaran 
        WHERE no_hp='$no_hp_final' 
        AND id_produk='$id_produk' 
        AND status_penawaran='menunggu'
    ");
    
    if (mysqli_num_rows($cek_pending) > 0) {
        $data_pending = mysqli_fetch_assoc($cek_pending);
        $id_pending = $data_pending['id'];
        
        // Update nominal harga dan reset waktu (tanggal) ke waktu sekarang
        $update_tawaran = mysqli_query($con, "
            UPDATE penawaran 
            SET harga_tawaran='$harga', tanggal=NOW() 
            WHERE id='$id_pending'
        ");
        
        if($update_tawaran){
            // Nendang balik ke beranda dengan membawa status "diperbarui"
            header("Location: index.php?penawaran=diperbarui");
        } else {
            echo "<script>
                alert('Sistem gagal memperbarui tawaran. Coba lagi ya.');
                window.history.back();
            </script>";
        }
        
        // KUNCI SAKTI: Wajib exit biar gak bablas nambah data baru
        exit;
    }

    //  LOGIC LIMIT 3X NAWAR 
    $cek_limit = mysqli_query($con, "
        SELECT COUNT(*) as total_nawar 
        FROM penawaran 
        WHERE no_hp='$no_hp_final' AND id_produk='$id_produk'
        AND DATE(tanggal) = CURDATE()
    ");
    $data_limit = mysqli_fetch_assoc($cek_limit);

    if ($data_limit['total_nawar'] >= 3) {
        echo "<script>
            alert('Maaf, jatah penawaranmu untuk produk ini sudah habis (Maks 3x sehari). Coba lagi besok ya!');
            window.history.back();
        </script>";
        exit;
    }

    // Lanjut simpan ke database
    $query = mysqli_query($con, "INSERT INTO penawaran 
    (id_produk, nama_penawar, no_hp, harga_tawaran) 
    VALUES 
    ('$id_produk','$nama','$no_hp_final','$harga')");

    if ($query) {
        header("Location: index.php?penawaran=success");
        exit;
    } else {
        echo "Gagal mengirim penawaran";
    }
}
?>