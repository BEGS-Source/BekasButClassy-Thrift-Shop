<?php
require "../koneksi.php";
// API Key Komerce V2 Lu
$api_key = RAJAONGKIR_API_KEY;

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'provinsi') {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array("key: $api_key"),
        ));
        echo curl_exec($curl);
        curl_close($curl);
    } 
    elseif ($action == 'kota') {
        $id_provinsi = $_GET['id_provinsi'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/city/$id_provinsi",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array("key: $api_key"),
        ));
        echo curl_exec($curl);
        curl_close($curl);
    }
    elseif ($action == 'kecamatan') { //  TAMBAHAN LEVEL KECAMATAN V2
        $id_kota = $_GET['id_kota'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/district/$id_kota",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array("key: $api_key"),
        ));
        echo curl_exec($curl);
        curl_close($curl);
    }
    // ... (kode atasnya biarin sama)
    elseif ($action == 'cost') {
        $id_kecamatan_tujuan = $_POST['id_kecamatan'];
        $kurir = strtolower($_POST['kurir']);
        $berat = 1000; 
        
        $id_kecamatan_asal = 2163; // ID Cimanggis

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$id_kecamatan_asal&destination=$id_kecamatan_tujuan&weight=$berat&courier=$kurir",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $api_key"
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        //   NORMALISASI HARGA SANDBOX 
        $data = json_decode($response, true);
        
        // Cek kalau API berhasil ngasih data harga
        if(isset($data['data']) && is_array($data['data'])) {
            foreach($data['data'] as $key => $value) {
                $harga_asli = $data['data'][$key]['cost'];
                
                // Kalau harganya ngawur di atas 30rb, kita potong biar wajar
                if($harga_asli > 30000) {
                    // Dibagi 4 atau 5, terus dibuletin ke ribuan terdekat
                    $harga_wajar = round(($harga_asli / 5) / 1000) * 1000;
                    
                    // Jaga-jaga jangan sampai kemurahan (Batas bawah 10rb)
                    if($harga_wajar < 10000) {
                        $harga_wajar = 10000;
                    }
                    
                    // Timpa harga aslinya
                    $data['data'][$key]['cost'] = $harga_wajar;
                }
            }
        }
        
        // Kirim harga yang udah "waras" ke website lu
        echo json_encode($data);
    }
}
?>