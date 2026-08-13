<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDN 3 Krenceng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon" />
    <style>
    /* ── Modern Navbar ── */
    .navbar-modern {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(137,10,10,0.08);
        padding: 0;
        transition: all 0.3s ease;
    }
    .navbar-modern.scrolled {
        box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        background: rgba(255,255,255,0.97);
    }
    .navbar-modern .navbar-brand img {
        height: 45px;
        transition: transform 0.3s ease;
    }
    .navbar-modern .navbar-brand:hover img {
        transform: scale(1.05);
    }
    .navbar-modern .nav-link {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2c2c2c;
        padding: 8px 16px !important;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }
    .navbar-modern .nav-link::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #890A0A, #c0392b);
        border-radius: 2px;
        transition: width 0.3s ease;
    }
    .navbar-modern .nav-link:hover::after {
        width: 60%;
    }
    .navbar-modern .nav-link:hover {
        color: #890A0A !important;
        background: rgba(137,10,10,0.04);
    }
    .navbar-modern .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 8px;
        margin-top: 8px;
        animation: dropdownFade 0.25s ease;
    }
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .navbar-modern .dropdown-item {
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 500;
        font-size: 0.88rem;
        transition: all 0.2s ease;
    }
    .navbar-modern .dropdown-item:hover {
        background: rgba(137,10,10,0.06);
        color: #890A0A;
        padding-left: 22px;
    }
    .btn-login-modern {
        background: linear-gradient(135deg, #890A0A, #b01515) !important;
        color: #ffff !important;
        border: none;
        border-radius: 10px !important;
        padding: 10px 24px !important;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(137,10,10,0.25);
    }
    .btn-login-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(137,10,10,0.35);
        background: linear-gradient(135deg, #a00c0c, #c91818) !important;
    }
    .navbar-toggler {
        border: 2px solid rgba(137,10,10,0.2) !important;
        border-radius: 8px;
        padding: 6px 10px;
    }
    .navbar-toggler:focus {
        box-shadow: 0 0 0 3px rgba(137,10,10,0.15);
    }

    /* ── Modern Footer ── */
    .footer-modern {
        background: linear-gradient(135deg, #1a0505 0%, #2d0a0a 40%, #1a0505 100%);
        position: relative;
        overflow: hidden;
    }
    .footer-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #890A0A, #c0392b, #890A0A, #c0392b, #890A0A);
    }
    .footer-modern::after {
        content: '';
        position: absolute;
        top: 4px;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(180deg, rgba(137,10,10,0.08), transparent);
        pointer-events: none;
    }
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }
    .footer-brand img {
        height: 50px;
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }
    .footer-brand-text {
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.5px;
    }
    .footer-desc {
        color: rgba(255,255,255,0.55);
        font-size: 0.88rem;
        line-height: 1.7;
        max-width: 320px;
    }
    .footer-heading {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #c0392b;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(90deg, #890A0A, transparent);
        border-radius: 2px;
    }
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-links li {
        margin-bottom: 10px;
    }
    .footer-links a {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .footer-links a:hover {
        color: #fff;
        padding-left: 6px;
    }
    .footer-links a i {
        font-size: 0.8rem;
        color: #890A0A;
        transition: color 0.3s ease;
    }
    .footer-links a:hover i {
        color: #c0392b;
    }
    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }
    .footer-contact-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: rgba(137,10,10,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c0392b;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .footer-contact-text {
        color: rgba(255,255,255,0.6);
        font-size: 0.88rem;
        font-weight: 500;
        line-height: 1.5;
    }
    .footer-contact-text a {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .footer-contact-text a:hover {
        color: #fff;
    }
    .footer-map-wrap {
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid rgba(137,10,10,0.2);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .footer-map-wrap iframe {
        display: block;
        width: 100%;
        height: 180px;
    }
    .footer-social {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }
    .footer-social a {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(137,10,10,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.6);
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .footer-social a:hover {
        background: #890A0A;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(137,10,10,0.4);
    }
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.06);
        padding: 20px 0;
        margin-top: 10px;
    }
    .footer-bottom p {
        color: rgba(255,255,255,0.35);
        font-size: 0.82rem;
        font-weight: 500;
        margin: 0;
    }
    .footer-bottom .heart {
        color: #890A0A;
    }
    </style>
  </head>
  <body style="font-family: 'Inter', 'Poppins', sans-serif;">

    {{-- Modern Navbar --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-modern" id="mainNavbar">
        <div class="container py-2">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SDN 3 Krenceng"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-house-door me-1"></i>Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-building me-1"></i>Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#profil"><i class="bi bi-info-circle me-2"></i>Tentang Kami</a></li>
                            <li><a class="dropdown-item" href="#struktur"><i class="bi bi-diagram-3 me-2"></i>Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="#fasilitas"><i class="bi bi-building me-2"></i>Fasilitas Sekolah</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prestasi"><i class="bi bi-trophy me-1"></i>Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#berita"><i class="bi bi-newspaper me-1"></i>Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profil"><i class="bi bi-people me-1"></i>Tentang Kami</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn-login-modern text-light" href="/login"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')


    {{-- Modern Footer --}}
    <footer class="footer-modern">
        <div class="container pt-5 pb-3">
            <div class="row g-4 py-3">
                {{-- Brand Column --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        <span class="footer-brand-text">SDN 3 Krenceng</span>
                    </div>
                    <p class="footer-desc">Menanamkan semangat belajar, membentuk generasi cerdas untuk masa depan yang gemilang.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                {{-- Menu Column --}}
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-heading">Menu</h6>
                    <ul class="footer-links">
                        <li><a href="#"><i class="bi bi-chevron-right"></i>Beranda</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right"></i>Profil</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right"></i>Prestasi</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right"></i>Berita</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right"></i>Tentang Kami</a></li>
                    </ul>
                </div>

                {{-- Kontak Column --}}
                <div class="col-lg-3 col-md-3 col-6">
                    <h6 class="footer-heading">Kontak</h6>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="footer-contact-text"><a href="tel:+628123456789">+628123456789</a></div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="footer-contact-text"><a href="mailto:example@gmail.com">example@gmail.com</a></div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="footer-contact-text">Krenceng, Kec. Krenceng, Kab. Serang, Banten</div>
                    </div>
                </div>

                {{-- Map Column --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Lokasi</h6>
                    <div class="footer-map-wrap">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12755.705334997747!2d109.44826127461008!3d-7.4058349303966695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6556988952dd07%3A0x1842e263153fddec!2sSD%20Negeri%203%20Krenceng!5e1!3m2!1sid!2sid!4v1759250376728!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="footer-bottom text-center">
                <p>Copyright &copy; {{ date('Y') }} SDN 3 Krenceng. Made with <span class="heart"><i class="bi bi-heart-fill"></i></span> for education.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    {{-- Navbar scroll effect --}}
    <script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    </script>

    @stack('scripts')
  </body>
</html>