<!-- Footer partial for Whispering Flora - resources/views/components/footer.blade.php -->
<style>
    /* Inline-critical footer styles (higher priority while debugging caching issues) */
    .site-footer {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.85), rgba(255,255,255,0)), var(--color-pastel-bliss-3);
        padding: 48px 28px 28px;
        box-sizing: border-box;
        color: var(--color-text-light);
    }

    .site-footer__inner {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 32px;
        align-items: start;
        padding-top: 18px;
    }

    .site-footer .footer-brand img {
        height: 36px;
        display: block;
        margin-bottom: 10px;
    }

    .site-footer .logo {
        font-family: var(--font-display);
        font-size: 28px;
        margin: 0 0 8px;
        color: var(--color-text-dark);
        letter-spacing: 0.4px;
    }

    .site-footer p {
        margin: 0 0 8px 0;
        color: var(--color-text-light);
        line-height: 1.6;
        max-width: 520px;
        font-size: 0.98rem;
    }

    .site-footer h4 {
        font-family: var(--font-display);
        font-size: 13px;
        margin: 0 0 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: left;
        color: var(--color-text-dark);
    }

    .site-footer ul {
        list-style: none;
        padding: 0;
        margin: 0
    }

    .site-footer ul li {
        margin: 8px 0
    }

    .site-footer ul li a {
        color: var(--color-text-dark);
        text-decoration: none;
        opacity: 0.9;
        transition: opacity 0.15s ease, transform 0.15s ease;
    }

    .site-footer ul li a:hover {
        opacity: 1;
        transform: translateX(2px);
        color: var(--color-accent-strong);
    }


    .site-footer__divider {
        margin-top: 28px;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        background: transparent;
        padding: 16px 8px;
    }

    .site-footer__legal {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .site-footer__legal .legal-links a {
        margin-left: 12px;
        color: var(--color-text-light);
        text-decoration: none;
        font-size: 0.95rem;
    }

    .site-footer__legal .legal-links a:hover { color: var(--color-accent-strong); }

    .site-footer__legal .copyright {
        font-weight: 800;
        color: var(--color-text-dark)
    }

    .site-footer .footer-inner> :nth-child(2) {
        padding-left: 28px;
        border-left: 1px solid rgba(0, 0, 0, 0.04);
    }

    @media (max-width:980px) {
        .site-footer__inner {
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .site-footer__inner>:nth-child(2) {
            border-left: none;
            padding-left: 0;
        }
    }

    @media (max-width:560px) {
        .site-footer__inner {
            grid-template-columns: 1fr;
            padding: 8px 18px;
        }

        .site-footer__legal {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
<footer class="site-footer" aria-label="Footer utama">
    <div class="site-footer__inner">

        <!-- Column 1: Brand (wider) -->
        <div class="footer-brand">
            <h3 class="logo">Whispering Flora</h3>
            <p>
                Dari kelopak pertama hingga akhir, kami merangkai setiap bunga dengan ketulusan,
                kreativitas, dan perhatian pada detail.
            </p>

            <div class="footer-social" style="margin-top:12px; display:flex; gap:10px; align-items:center;">
                <a href="#" aria-label="Instagram" style="color:var(--color-text-dark); text-decoration:none;">Instagram</a>
                <a href="#" aria-label="WhatsApp" style="color:var(--color-text-dark); text-decoration:none;">WhatsApp</a>
                <a href="#" aria-label="Email" style="color:var(--color-text-dark); text-decoration:none;">Email</a>
            </div>
        </div>

        <!-- Column 2: PAGES -->
        <div class="footer-col">
            <h4>PAGES</h4>
            <ul>
                <li><a href="{{ route('about.index') }}">About Us</a></li>
                <li><a href="{{ route('catalog.index') }}">Products</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contacts</a></li>
                <li><a href="{{ route('cart') }}">Cart Page</a></li>
            </ul>
        </div>

        <!-- Column 3: INFORMATION -->
        <div class="footer-col">
            <h4>INFORMATION</h4>
            <ul>
                <li><a href="#">Corporate Partnership</a></li>
                <li><a href="#">Join Partner</a></li>
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Customer Services</a></li>
            </ul>
        </div>

        <!-- Column 4: COMPANIES -->
        <div class="footer-col">
            <h4>COMPANIES</h4>
            <ul>
                <li><a href="#">Press Release</a></li>
                <li><a href="#">Career</a></li>
                <li><a href="#">How To Order</a></li>
                <li><a href="#">Reports</a></li>
            </ul>
        </div>

    </div>

    <!-- Horizontal divider + legal row -->
    <div class="site-footer__divider">
        <div class="site-footer__legal">
            <div class="copyright">&copy; {{ date('Y') }} Whispering Flora. Semua hak dilindungi.</div>
            <nav class="legal-links" aria-label="Footer legal">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
                <a href="#">Kontak Kami</a>
            </nav>
        </div>
    </div>
</footer>
