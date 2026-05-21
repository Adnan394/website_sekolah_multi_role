<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDN 3 Krenceng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  </head>
  <body>

    {{-- navbar  --}}
    <nav class="navbar navbar-expand-lg bg-light shadow-sm fixed-top">
        <div class="container py-2">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link text-black" aria-current="page" href="#">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-black dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profil
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Tentang Kami</a></li>
                        <li><a class="dropdown-item" href="#">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="#">Fasilitas Sekolah</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" aria-current="page" href="#">Prestasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" aria-current="page" href="#">Berita</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link text-black" aria-current="page" href="#">Tentang Kami</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link text-black btn btn-main btn-block px-4 py-2" aria-current="page" href="/login"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    @yield('content')


    <footer class="bg-main">
        <div class="container text-white pt-5">
            <div class="row py-3">
                <div class="col-6 col-md-2">
                    <h4 class="fw-600">Menu</h4>
                    <ul class="list-unstyled">
                        <li><a href="" class="text-white"><i class="bi bi-house-door me-2"></i>Beranda</a></li>
                        <li><a href="" class="text-white"><i class="bi bi-person-lines-fill me-2"></i>Profil</a></li>
                        <li><a href="" class="text-white"><i class="bi bi-trophy me-2"></i>Prestasi</a></li>
                        <li><a href="" class="text-white"><i class="bi bi-globe me-2"></i>Berita</a></li>
                        <li><a href="" class="text-white"><i class="bi bi-person-lines-fill me-2"></i>Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-6">
                    <h4 class="fw-600">Kontak</h4>
                    <ul class="list-unstyled">
                        <li><a href="" class="text-white"><i class="bi bi-telephone-inbound me-2"></i>+628123456789</a></li>
                        <li><a href="" class="text-white"><i class="bi bi-envelope me-2"></i>example@gmail.com</a></li>
                    </ul>
                </div>
                <div class="col-4">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic, illum.</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12755.705334997747!2d109.44826127461008!3d-7.4058349303966695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6556988952dd07%3A0x1842e263153fddec!2sSD%20Negeri%203%20Krenceng!5e1!3m2!1sid!2sid!4v1759250376728!5m2!1sid!2sid" width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <hr class="text-white">
            <div class="row">
                <div class="col">
                    <p class="text-white text-center">Copyright &copy; 2023 SDN 3 Krenceng</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>