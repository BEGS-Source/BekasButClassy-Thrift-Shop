<?php
$ig_username  = "bekas_butclassy";       
$wa_nomor     = "------";        
$maps_query   = "-----";   
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <div class="row gy-3 align-items-center">
                
                <!-- Brand Section -->
                <div class="col-12 col-md-5 text-center">
                    <img src="../image/BekasButClassy.png" width="45" alt="Logo BekasButClassy" class="mb-2">
                    <h5 class="footer-brand mb-1">BekasButClassy</h5>
                    <p class="footer-tagline mb-2">
                        Thrift dengan gaya, hemat dengan elegan.<br>
                        Semoga nyaman belanja di sini!
                    </p>
                    <div class="footer-social justify-content-center">
                        <a href="https://instagram.com/<?= htmlspecialchars($ig_username) ?>" target="_blank" class="social-icon" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/<?= htmlspecialchars($wa_nomor) ?>" target="_blank" class="social-icon" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Maps Section -->
                <div class="col-12 col-md-7 text-center">
                    <h6 class="footer-heading mb-2">Kunjungi Toko Kami</h6>
                    <div class="footer-map-wrap mx-auto">
                        <iframe
                            src="https://www.google.com/maps?q=<?= urlencode($maps_query) ?>&z=15&output=embed"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi BekasButClassy">
                        </iframe>
                    </div>
                    <a class="footer-map-link" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($maps_query) ?>" target="_blank">
                        <i class="fas fa-map-marker-alt me-1"></i> Buka di Google Maps
                    </a>
                </div>

            </div>
            
            <div class="footer-divider"></div>
            
            <p class="footer-copy text-center mb-0">
                &copy; <?= date('Y') ?> BekasButClassy. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(135deg, #F48FB1 0%, #d97ba0 100%);
        color: #fff;
        padding: 25px 0 15px;
        margin-top: 30px;
        font-family: 'Poppins', sans-serif;
    }
    
    .footer-inner {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .footer-brand {
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
    }
    .footer-tagline {
        font-size: 11px;
        font-style: italic;
        opacity: 0.95;
        line-height: 1.5;
    }
    .footer-heading {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
        opacity: 0.9;
    }
    
    .footer-social {
        display: flex;
        gap: 8px;
    }
    
    .social-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .social-icon:hover {
        background: #fff;
        color: #F48FB1;
        transform: translateY(-2px);
    }
    
    .footer-map-wrap {
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.4);
        width: 100%;
        max-width: 260px;
    }
    .footer-map-wrap iframe {
        display: block;
        width: 100%;
        height: 120px;
        border: 0;
    }
    .footer-map-link {
        display: inline-block;
        margin-top: 8px;
        font-size: 11px;
        color: #fff;
        opacity: 0.9;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .footer-map-link:hover {
        opacity: 1;
        text-decoration: underline;
    }
    .footer-divider {
        height: 1px;
        background: rgba(255,255,255,0.3);
        margin: 20px 0 12px;
    }
    .footer-copy {
        font-size: 10px;
        opacity: 0.85;
    }
    
    @media (max-width: 768px) {
        .site-footer {
            padding: 20px 0 12px;
        }
        .footer-brand {
            font-size: 1.05rem;
        }
        .footer-tagline {
            font-size: 10px;
        }
        .social-icon {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
        .footer-map-wrap {
            max-width: 100%;
        }
        .footer-map-wrap iframe {
            height: 110px;
        }
    }
</style>