<?php
// Pastikan variabel $wa_nomor sudah ada, jika tidak, set default
if (!isset($wa_nomor)) { $wa_nomor = "-------"; }
?>

<!-- Floating Help Button (Tombol Bantuan Mengambang) -->
<div class="help-fab-container">
    <div class="help-fab-menu" id="helpMenu">
        <a href="cara-pemesanan.php" class="help-fab-item"><i class="fas fa-shopping-bag"></i> Cara Pesan</a>
        <a href="cara-penawaran.php" class="help-fab-item"><i class="fas fa-gavel"></i> Cara Tawar</a>
        <a href="cek-pesanan.php" class="help-fab-item"><i class="fas fa-box"></i> Cek Pesanan</a>
        <a href="cek-penawaran.php" class="help-fab-item"><i class="fas fa-tags"></i> Cek Penawaran</a>
        <a href="https://wa.me/<?= htmlspecialchars($wa_nomor) ?>" target="_blank" class="help-fab-item wa"><i class="fab fa-whatsapp"></i> Chat Admin</a>
    </div>
    <button class="help-fab-btn" id="helpFabBtn" aria-label="Bantuan">
        <i class="fas fa-question"></i>
    </button>
</div>

<style>
.help-fab-container {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 9999;
    display: flex;
    flex-direction: column-reverse;
    align-items: flex-end;
    gap: 10px;
}
.help-fab-btn {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #F48FB1, #e57da0);
    color: white;
    border: none;
    font-size: 24px;
    box-shadow: 0 6px 20px rgba(244, 143, 177, 0.5);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    animation: pulse-help 2s infinite;
}
.help-fab-btn:hover { transform: scale(1.1); }
.help-fab-btn.active { animation: none; background: #e57da0; transform: rotate(90deg); }

.help-fab-menu {
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.help-fab-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.help-fab-item {
    background: white;
    color: #333;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    transition: all 0.2s;
}
.help-fab-item:hover { background: #FFF0F5; color: #F48FB1; transform: translateX(-5px); }
.help-fab-item.wa { background: #25D366; color: white; }
.help-fab-item.wa:hover { background: #1DA851; color: white; }

@keyframes pulse-help {
    0% { box-shadow: 0 0 0 0 rgba(244, 143, 177, 0.7); }
    70% { box-shadow: 0 0 0 15px rgba(244, 143, 177, 0); }
    100% { box-shadow: 0 0 0 0 rgba(244, 143, 177, 0); }
}
@media (max-width: 480px) {
    .help-fab-container { bottom: 20px; right: 20px; }
    .help-fab-btn { width: 50px; height: 50px; font-size: 20px; }
    .help-fab-item { font-size: 12px; padding: 8px 14px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('helpFabBtn');
    const menu = document.getElementById('helpMenu');
    if(btn && menu) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            btn.classList.toggle('active');
            menu.classList.toggle('show');
        });
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                btn.classList.remove('active');
                menu.classList.remove('show');
            }
        });
    }
});
</script>