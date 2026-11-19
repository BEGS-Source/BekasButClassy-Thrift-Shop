<?php
class CBFEngine {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // 1. Ambil atribut produk (Kategori, Brand, Size) dari database lu
    private function getProdukFeatures($produk_id) {
        $query = mysqli_query($this->con, "SELECT kategori_id, brand, size FROM produk WHERE id = '$produk_id'");
        $produk = mysqli_fetch_assoc($query);

        if (!$produk) return [];

        return [
            'kat_'   . $produk['kategori_id'],
            'brand_' . strtolower(str_replace(' ', '_', $produk['brand'])),
            'size_'  . strtoupper($produk['size'])
        ];
    }

    // 2. menghitung Jaccard Similarity Irisan dibagi Gabungan
    private function jaccardSimilarity($setA, $setB) {
        if (empty($setA) || empty($setB)) return 0;

        $irisan = count(array_intersect($setA, $setB));
        $gabungan = count(array_unique(array_merge($setA, $setB)));

        if ($gabungan == 0) return 0;
        return round($irisan / $gabungan, 4);
    }

    
    // Proses cari rekomendasi untuk ditampilkan di web
    public function getSimilarProduk($produk_id, $limit = 4) {
        $targetFeatures = $this->getProdukFeatures($produk_id);
        if (empty($targetFeatures)) return [];

        // query SQL
        $queryAll = mysqli_query($this->con, "SELECT id, nama, harga, foto, detail FROM produk WHERE ketersediaan_stok = 'Ready' AND id != '$produk_id'");

        $scores = [];
        while ($item = mysqli_fetch_assoc($queryAll)) {
            $itemFeatures = $this->getProdukFeatures($item['id']);
            $score = $this->jaccardSimilarity($targetFeatures, $itemFeatures);

            if ($score > 0) {
                $scores[] = [
                    'id'          => $item['id'],
                    'nama'        => $item['nama'],
                    'harga'       => $item['harga'],
                    'foto'        => $item['foto'],
                    'detail'      => $item['detail'], // Detail disimpan ke dalam array
                    'score'       => $score,
                ];
            }
        }

        // Urutkan: Score Jaccard tertinggi dulu. Kalau seri, ambil produk yang paling baru di-upload (ID terbesar)
        usort($scores, function($a, $b) {
            if ($b['score'] != $a['score']) {
                return $b['score'] <=> $a['score'];
            }
            return $b['id'] <=> $a['id']; 
        });

        return array_slice($scores, 0, $limit);
    }
}
?>