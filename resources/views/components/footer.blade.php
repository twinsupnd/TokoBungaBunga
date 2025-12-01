<!-- Footer partial for Whispering Flora - resources/views/components/footer.blade.php -->
<style>
    /* Inline-critical footer styles (higher priority while debugging caching issues) */
    .site-footer {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.6), rgba(0, 0, 0, 0.00)), var(--color-pastel-bliss-3);
        padding: 90px 40px 40px;
        box-sizing: border-box
    }

    .site-footer__inner {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 60px;
        align-items: start;
        padding-top: 48px
    }

    .site-footer .footer-brand img {
        height: 36px;
        display: block;
        margin-bottom: 10px
    }

    .site-footer .logo {
        font-family: var(--font-display);
        font-size: 40px;
        margin: 0 0 12px;
        color: var(--color-text-dark)
    }

    .site-footer p {
        margin: 0;
        color: var(--color-text-light);
        line-height: 2.05;
        max-width: 560px
    }

    .site-footer h4 {
        font-family: var(--font-display);
        font-size: 26px;
        margin: 0 0 18px;
        text-transform: uppercase;
        letter-spacing: 6px;
        text-align: center
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
        color: #4e4a4e;
        text-decoration: none
    }

    .site-footer__divider {
        margin-top: 40px;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        background: var(--color-pastel-bliss-2);
        padding: 20px
    }

    .site-footer__legal {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        color: #6b7280
    }

    .site-footer__legal .copyright {
        font-weight: 800;
        color: var(--color-text-dark)
    }

    .site-footer .footer-inner> :nth-child(2) {
        padding-left: 48px;
        border-left: 1px solid rgba(0, 0, 0, 0.08)
    }

    @media (max-width:980px) {
        .site-footer__inner {
            grid-template-columns: 1fr 1fr;
            gap: 28px
        }

        .site-footer__inner>:nth-child(2) {
            border-left: none;
            padding-left: 0
        }
    }

    @media (max-width:560px) {
        .site-footer__inner {
            grid-template-columns: 1fr;
            padding: 8px 18px
        }

        .site-footer__legal {
            flex-direction: column
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
