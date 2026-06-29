@extends('layouts.app')

@section('content')

<style>
/* ── Section Titles ── */
.section-title-modern {
    font-weight: 800;
    font-size: 2rem;
    color: #890A0A;
    margin-bottom: 12px;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}
.section-title-modern i {
    font-size: 1.6rem;
    opacity: 0.7;
}
.section-subtitle {
    color: #888;
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 40px;
}
.section-divider {
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #890A0A, #c0392b);
    border-radius: 4px;
    margin: 12px auto 20px;
}

/* ── Hero ── */
.hero-modern {
    min-height: 100vh;
    background: linear-gradient(160deg, rgba(26,5,5,0.85) 0%, rgba(137,10,10,0.65) 50%, rgba(26,5,5,0.9) 100%),
                url("{{ asset('img/hero.png') }}");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: white;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.hero-modern::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(transparent, #f8f9fa);
    pointer-events: none;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 24px;
    animation: fadeSlideUp 0.8s ease 0.2s both;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    letter-spacing: -1px;
    margin-bottom: 20px;
    text-shadow: 0 4px 30px rgba(0,0,0,0.3);
    animation: fadeSlideUp 0.8s ease 0.4s both;
}
.hero-subtitle {
    font-size: 1.15rem;
    font-weight: 400;
    max-width: 600px;
    margin: 0 auto 32px;
    opacity: 0.9;
    line-height: 1.7;
    animation: fadeSlideUp 0.8s ease 0.6s both;
}
.hero-cta {
    animation: fadeSlideUp 0.8s ease 0.8s both;
}
.hero-cta .btn {
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}
.hero-cta .btn-light {
    background: #fff;
    color: #890A0A;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.hero-cta .btn-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}
.hero-cta .btn-outline-light {
    border: 2px solid rgba(255,255,255,0.4);
    color: #fff;
}
.hero-cta .btn-outline-light:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.6);
    transform: translateY(-3px);
}
.hero-scroll-indicator {
    position: absolute;
    bottom: 140px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    animation: bounce 2s infinite;
}
.hero-scroll-indicator i {
    font-size: 1.5rem;
    color: rgba(255,255,255,0.5);
}
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-12px); }
    60% { transform: translateX(-50%) translateY(-6px); }
}

/* ── Profil Section ── */
.profil-section {
    padding: 80px 0;
}
.profil-img-wrap {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(137,10,10,0.12);
}
.profil-img-wrap::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 3px solid rgba(137,10,10,0.1);
    border-radius: 20px;
    z-index: 1;
    pointer-events: none;
}
.profil-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.profil-img-wrap:hover img {
    transform: scale(1.03);
}
.profil-content {
    padding-left: 20px;
}
.profil-content .section-title-modern {
    text-align: left;
}
.profil-text {
    text-align: justify;
    color: #555;
    font-size: 0.95rem;
    line-height: 1.8;
}
.profil-stats {
    display: flex;
    gap: 28px;
    margin-top: 24px;
    flex-wrap: wrap;
}
.profil-stat-item {
    text-align: center;
}
.profil-stat-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: #890A0A;
    line-height: 1;
}
.profil-stat-label {
    font-size: 0.78rem;
    color: #999;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 4px;
}
.btn-readmore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: 2px solid #890A0A;
    color: #890A0A;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 16px;
}
.btn-readmore:hover {
    background: #890A0A;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(137,10,10,0.25);
}
.btn-readmore i {
    transition: transform 0.3s ease;
}
.btn-readmore[aria-expanded="true"] i {
    transform: rotate(180deg);
}

/* ── Struktur Organisasi Cards ── */
.struktur-section {
    background: linear-gradient(135deg, #fdf2f2 0%, #f8f9fa 50%, #fdf2f2 100%);
    padding: 80px 0;
}
.struktur-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
    max-width: 1100px;
    margin: 0 auto;
}
.struktur-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 22px 14px 18px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(137, 10, 10, 0.06);
    transition: transform 0.35s cubic-bezier(.25,.8,.25,1), box-shadow 0.35s cubic-bezier(.25,.8,.25,1);
    border: 1px solid rgba(137, 10, 10, 0.06);
}
.struktur-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #890A0A, #c0392b, #890A0A);
    border-radius: 14px 14px 0 0;
}
.struktur-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(137, 10, 10, 0.14);
}
.struktur-photo-wrap {
    position: relative;
    width: 85px;
    height: 85px;
    margin: 0 auto 12px;
}
.struktur-photo-ring {
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: conic-gradient(#890A0A 0deg, #c0392b 120deg, #890A0A 240deg, #c0392b 360deg);
    animation: ringRotate 6s linear infinite;
}
@keyframes ringRotate {
    to { transform: rotate(360deg); }
}
.struktur-photo-ring-inner {
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    background: #fff;
}
.struktur-photo {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    object-fit: cover;
    position: relative;
    z-index: 2;
    border: 3px solid #fff;
    filter: grayscale(10%);
    transition: filter 0.3s ease, transform 0.3s ease;
}
.struktur-card:hover .struktur-photo {
    filter: grayscale(0%);
    transform: scale(1.05);
}
.struktur-photo-placeholder {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    position: relative;
    z-index: 2;
    background: linear-gradient(135deg, #f0d0d0, #fce4e4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #890A0A;
    border: 3px solid #fff;
}
.struktur-info { margin-top: 4px; }
.struktur-nama {
    font-size: 0.82rem;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.struktur-nama i { color: #890A0A; font-size: 0.78rem; }
.struktur-jabatan {
    font-size: 0.72rem;
    font-weight: 500;
    color: #fff;
    background: linear-gradient(135deg, #890A0A, #b01515);
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 0.3px;
}
.struktur-jabatan i { font-size: 0.68rem; }

/* Children sub-grid */
.struktur-children-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 30px 0 16px;
    font-size: 0.85rem;
    color: #890A0A;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.struktur-children-title::before,
.struktur-children-title::after {
    content: '';
    flex: 1;
    max-width: 80px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #890A0A);
}
.struktur-children-title::after {
    background: linear-gradient(90deg, #890A0A, transparent);
}
.struktur-children-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 16px;
    max-width: 1100px;
    margin: 0 auto;
}
.struktur-child-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 16px 12px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(137, 10, 10, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 3px solid #890A0A;
}
.struktur-child-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(137, 10, 10, 0.1);
}
.struktur-child-card .struktur-photo-wrap {
    width: 60px; height: 60px;
    margin-bottom: 10px;
}
.struktur-child-card .struktur-photo-ring { inset: -3px; }
.struktur-child-card .struktur-photo { width: 60px; height: 60px; }
.struktur-child-card .struktur-photo-placeholder {
    width: 60px; height: 60px; font-size: 22px;
}
.struktur-child-card .struktur-nama { font-size: 0.78rem; }
.struktur-child-card .struktur-jabatan { font-size: 0.68rem; padding: 2px 8px; }

/* ── Show More Button ── */
.btn-show-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: 2px solid #890A0A;
    color: #890A0A;
    padding: 10px 28px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 24px;
}
.btn-show-more:hover {
    background: #890A0A;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(137,10,10,0.25);
}
.btn-show-more i {
    transition: transform 0.3s ease;
}
.btn-show-more[aria-expanded="true"] i {
    transform: rotate(180deg);
}

/* ── Fasilitas Cards ── */
.fasilitas-section {
    padding: 80px 0;
}
.fasilitas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
    max-width: 1100px;
    margin: 0 auto;
}
.fasilitas-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 28px 16px 22px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(137, 10, 10, 0.06);
    transition: transform 0.35s cubic-bezier(.25,.8,.25,1), box-shadow 0.35s cubic-bezier(.25,.8,.25,1);
    border: 1px solid rgba(137, 10, 10, 0.06);
}
.fasilitas-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #890A0A, #c0392b, #890A0A);
    border-radius: 14px 14px 0 0;
}
.fasilitas-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(137, 10, 10, 0.14);
}
.fasilitas-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(137,10,10,0.08), rgba(192,57,43,0.08));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    font-size: 1.5rem;
    color: #890A0A;
    transition: all 0.3s ease;
}
.fasilitas-card:hover .fasilitas-icon {
    background: linear-gradient(135deg, #890A0A, #b01515);
    color: #fff;
    transform: scale(1.1);
}
.fasilitas-nama {
    font-size: 0.88rem;
    font-weight: 700;
    color: #2c2c2c;
}

/* ── Prestasi Section ── */
.prestasi-section {
    background: linear-gradient(135deg, #1a0505 0%, #2d0a0a 50%, #1a0505 100%);
    padding: 80px 0;
    position: relative;
}
.prestasi-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #890A0A, #c0392b, #890A0A, #c0392b, #890A0A);
}
.prestasi-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 24px;
}
.prestasi-card:hover {
    background: rgba(255,255,255,0.07);
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
}
.prestasi-img-wrap {
    border-radius: 14px;
    overflow: hidden;
    height: 200px;
    margin: 12px;
}
.prestasi-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.prestasi-card:hover .prestasi-img-wrap img {
    transform: scale(1.05);
}
.prestasi-content {
    padding: 8px 20px 20px;
}
.prestasi-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(137,10,10,0.2);
    color: #c0392b;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    margin-bottom: 10px;
}
.prestasi-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
}
.prestasi-desc {
    color: rgba(255,255,255,0.55);
    font-size: 0.88rem;
    line-height: 1.6;
}

/* ── Berita Section ── */
.berita-section {
    padding: 80px 0;
}
.berita-search-wrap {
    max-width: 500px;
    margin: 0 auto 36px;
    position: relative;
}
.berita-search-wrap input {
    width: 100%;
    padding: 14px 20px 14px 48px;
    border: 2px solid rgba(137,10,10,0.12);
    border-radius: 14px;
    font-size: 0.92rem;
    font-weight: 500;
    background: #fff;
    transition: all 0.3s ease;
    outline: none;
}
.berita-search-wrap input:focus {
    border-color: #890A0A;
    box-shadow: 0 4px 20px rgba(137,10,10,0.1);
}
.berita-search-wrap i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #890A0A;
    font-size: 1.1rem;
}
.berita-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
}
.berita-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.35s ease;
    border: 1px solid rgba(0,0,0,0.04);
}
.berita-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 40px rgba(137,10,10,0.12);
}
.berita-card-img {
    height: 200px;
    overflow: hidden;
    position: relative;
}
.berita-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.berita-card:hover .berita-card-img img {
    transform: scale(1.08);
}
.berita-card-img .berita-category {
    position: absolute;
    top: 14px;
    left: 14px;
    background: linear-gradient(135deg, #890A0A, #b01515);
    color: #fff;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.berita-card-body {
    padding: 20px;
}
.berita-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 8px;
    line-height: 1.4;
}
.berita-card-desc {
    color: #888;
    font-size: 0.85rem;
    line-height: 1.6;
    margin-bottom: 14px;
}
.berita-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid #f0f0f0;
}
.berita-card-date {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #aaa;
    font-size: 0.8rem;
    font-weight: 500;
}
.berita-card-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #890A0A;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: gap 0.3s ease;
}
.berita-card-link:hover {
    gap: 8px;
    color: #b01515;
}
.berita-no-result {
    display: none;
    text-align: center;
    padding: 40px;
    color: #aaa;
    font-size: 0.95rem;
}
.berita-no-result.active {
    display: block;
}
</style>


{{-- HERO --}}
<section class="hero-modern" id="beranda">
    <div class="container text-center position-relative" style="z-index:2;">
        <div class="hero-badge">
            <i class="bi bi-mortarboard-fill"></i>
            Selamat Datang di Website Resmi
        </div>
        <h1 class="hero-title">SDN 3 KRENCENG</h1>
        <p class="hero-subtitle">Menanamkan semangat belajar, membentuk generasi cerdas untuk masa depan yang gemilang</p>
        <div class="hero-cta d-flex gap-3 justify-content-center flex-wrap">
            <a href="#profil" class="btn btn-light"><i class="bi bi-info-circle me-2"></i>Tentang Kami</a>
            <a href="/login" class="btn btn-outline-light"><i class="bi bi-box-arrow-in-right me-2"></i>Portal Login</a>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <i class="bi bi-chevron-double-down"></i>
    </div>
</section>


{{-- PROFIL SEKOLAH --}}
<section class="profil-section" id="profil">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="profil-img-wrap">
                    <img src="{{ asset('uploads/tentang_kami/'.$tentang->gambar ?? 'img/dummy.png') }}" alt="Profil SDN 3 Krenceng">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="profil-content">
                    <h2 class="section-title-modern"><i class="bi bi-building"></i> PROFIL SEKOLAH</h2>
                    <div class="section-divider" style="margin-left:0;"></div>
                    
                    <div class="profil-text">
                        <div id="profilShort">
                            {!! Str::limit($tentang->tentang_kami ?? '', 300) !!}
                        </div>
                        <div class="collapse" id="profilFull">
                            {!! $tentang->tentang_kami ?? '' !!}
                        </div>
                    </div>

                    @if(strlen($tentang->tentang_kami ?? '') > 300)
                    <button class="btn-readmore" type="button" data-bs-toggle="collapse" data-bs-target="#profilFull" aria-expanded="false" aria-controls="profilFull" onclick="toggleProfil(this)">
                        <i class="bi bi-chevron-down"></i>
                        <span>Baca Selengkapnya</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


{{-- STRUKTUR ORGANISASI --}}
<section class="struktur-section" id="struktur">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title-modern"><i class="bi bi-diagram-3"></i> STRUKTUR ORGANISASI</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Jajaran pengurus dan tenaga pendidik SDN 3 Krenceng</p>
        </div>

        {{-- Parent cards - show first 6 --}}
        <div class="struktur-grid">
            @foreach($struktur->take(6) as $item)
                <div class="struktur-card">
                    <div class="struktur-photo-wrap">
                        <div class="struktur-photo-ring">
                            <div class="struktur-photo-ring-inner"></div>
                        </div>
                        @if($item->foto)
                            <img src="{{ asset('uploads/struktur/' . $item->foto) }}" alt="{{ $item->nama }}" class="struktur-photo">
                        @else
                            <div class="struktur-photo-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>
                    <div class="struktur-info">
                        <div class="struktur-nama">
                            <i class="bi bi-person-badge-fill"></i>
                            {{ $item->nama }}
                        </div>
                        <span class="struktur-jabatan">
                            <i class="bi bi-briefcase-fill"></i>
                            {{ $item->jabatan }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Collapsible remaining cards --}}
        @if($struktur->count() > 6)
        <div class="collapse" id="strukturMore">
            <div class="struktur-grid mt-3">
                @foreach($struktur->skip(6) as $item)
                    <div class="struktur-card">
                        <div class="struktur-photo-wrap">
                            <div class="struktur-photo-ring">
                                <div class="struktur-photo-ring-inner"></div>
                            </div>
                            @if($item->foto)
                                <img src="{{ asset('uploads/struktur/' . $item->foto) }}" alt="{{ $item->nama }}" class="struktur-photo">
                            @else
                                <div class="struktur-photo-placeholder">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                        </div>
                        <div class="struktur-info">
                            <div class="struktur-nama">
                                <i class="bi bi-person-badge-fill"></i>
                                {{ $item->nama }}
                            </div>
                            <span class="struktur-jabatan">
                                <i class="bi bi-briefcase-fill"></i>
                                {{ $item->jabatan }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Children cards --}}
        @foreach($struktur as $item)
            @if($item->children->count())
                <div class="struktur-children-title">
                    <i class="bi bi-people-fill"></i> Anggota {{ $item->jabatan }}
                </div>
                <div class="struktur-children-grid">
                    @foreach($item->children as $child)
                        <div class="struktur-child-card">
                            <div class="struktur-photo-wrap">
                                <div class="struktur-photo-ring">
                                    <div class="struktur-photo-ring-inner"></div>
                                </div>
                                @if($child->foto)
                                    <img src="{{ asset('uploads/struktur/' . $child->foto) }}" alt="{{ $child->nama }}" class="struktur-photo">
                                @else
                                    <div class="struktur-photo-placeholder">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="struktur-info">
                                <div class="struktur-nama">
                                    <i class="bi bi-person-fill"></i>
                                    {{ $child->nama }}
                                </div>
                                <span class="struktur-jabatan">
                                    <i class="bi bi-briefcase-fill"></i>
                                    {{ $child->jabatan }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

        @if($struktur->count() > 6)
        <div class="text-center">
            <button class="btn-show-more" type="button" data-bs-toggle="collapse" data-bs-target="#strukturMore" aria-expanded="false" onclick="toggleShowMore(this, 'Struktur')">
                <i class="bi bi-chevron-down"></i>
                <span>Lihat Selengkapnya</span>
            </button>
        </div>
        @endif
    </div>
</section>


{{-- FASILITAS SEKOLAH --}}
<section class="fasilitas-section" id="fasilitas">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title-modern"><i class="bi bi-building"></i> FASILITAS SEKOLAH</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Fasilitas pendukung kegiatan belajar mengajar</p>
        </div>

        <div class="fasilitas-grid">
            @php
                $fasilitasIcons = [
                    'Ruang Kelas' => 'bi-door-open',
                    'Perpustakaan' => 'bi-book',
                    'Laboratorium' => 'bi-cpu',
                    'Musholla' => 'bi-moon-stars',
                    'Lapangan' => 'bi-dribbble',
                    'UKS' => 'bi-heart-pulse',
                    'Kantin' => 'bi-cup-straw',
                    'Toilet' => 'bi-droplet',
                    'Parkir' => 'bi-car-front',
                    'Aula' => 'bi-columns-gap',
                    'Gudang' => 'bi-box-seam',
                    'Kantor' => 'bi-briefcase',
                ];
            @endphp
            @foreach($fasilitas as $item)
                <div class="fasilitas-card">
                    <div class="fasilitas-icon">
                        <i class="bi {{ $fasilitasIcons[$item->nama] ?? 'bi-building' }}"></i>
                    </div>
                    <div class="fasilitas-nama">{{ $item->nama }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- PRESTASI SEKOLAH --}}
<section class="prestasi-section" id="prestasi">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title-modern" style="color: #fff;"><i class="bi bi-trophy"></i> PRESTASI SEKOLAH</h2>
            <div class="section-divider" style="background: linear-gradient(90deg, #c0392b, #890A0A);"></div>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.45);">Pencapaian dan penghargaan yang membanggakan</p>
        </div>

        <div class="row">
            @foreach($prestasi->take(3) as $item)
            <div class="col-lg-4 col-md-6">
                <div class="prestasi-card">
                    <div class="prestasi-img-wrap">
                        <img src="{{ asset('uploads/prestasi/'.$item->gambar) }}" alt="{{ $item->title }}">
                    </div>
                    <div class="prestasi-content">
                        <span class="prestasi-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                        <h4 class="prestasi-title">{{ $item->title }}</h4>
                        <p class="prestasi-desc">{!! Str::limit($item->description, 120) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($prestasi->count() > 3)
        <div class="collapse" id="prestasiMore">
            <div class="row">
                @foreach($prestasi->skip(3) as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="prestasi-card">
                        <div class="prestasi-img-wrap">
                            <img src="{{ asset('uploads/prestasi/'.$item->gambar) }}" alt="{{ $item->title }}">
                        </div>
                        <div class="prestasi-content">
                            <span class="prestasi-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            <h4 class="prestasi-title">{{ $item->title }}</h4>
                            <p class="prestasi-desc">{!! Str::limit($item->description, 120) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <button class="btn-show-more" type="button" style="border-color: rgba(255,255,255,0.3); color: rgba(255,255,255,0.7);" data-bs-toggle="collapse" data-bs-target="#prestasiMore" aria-expanded="false" onclick="toggleShowMore(this, 'Prestasi')"
                onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff';" onmouseout="this.style.background='none';this.style.color='rgba(255,255,255,0.7)';">
                <i class="bi bi-chevron-down"></i>
                <span>Lihat Selengkapnya</span>
            </button>
        </div>
        @endif
    </div>
</section>


{{-- BERITA --}}
<section class="berita-section" id="berita">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title-modern"><i class="bi bi-newspaper"></i> BERITA</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Informasi terbaru seputar kegiatan sekolah</p>
        </div>

        {{-- Search Bar --}}
        <div class="berita-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="beritaSearch" placeholder="Cari berita berdasarkan judul atau deskripsi..." oninput="filterBerita()">
        </div>

        <div class="berita-grid" id="beritaGrid">
            @php
                $dummyBerita = [
                    ['title' => 'Pengumuman', 'desc' => 'Informasi penting mengenai kegiatan akademik dan jadwal terbaru dari sekolah.', 'category' => 'Pengumuman', 'date' => '15 Jun 2025'],
                    ['title' => 'Kegiatan Sekolah', 'desc' => 'Dokumentasi dan laporan kegiatan belajar mengajar serta ekstrakurikuler.', 'category' => 'Kegiatan', 'date' => '12 Jun 2025'],
                    ['title' => 'Informasi', 'desc' => 'Berbagai informasi umum seputar pendaftaran dan program sekolah terbaru.', 'category' => 'Info', 'date' => '10 Jun 2025'],
                ];
            @endphp
            @foreach($dummyBerita as $berita)
            <div class="berita-card" data-title="{{ strtolower($berita['title']) }}" data-desc="{{ strtolower($berita['desc']) }}">
                <div class="berita-card-img">
                    <img src="{{ asset('img/dummy.png') }}" alt="{{ $berita['title'] }}">
                    <span class="berita-category">{{ $berita['category'] }}</span>
                </div>
                <div class="berita-card-body">
                    <h5 class="berita-card-title">{{ $berita['title'] }}</h5>
                    <p class="berita-card-desc">{{ $berita['desc'] }}</p>
                    <div class="berita-card-footer">
                        <span class="berita-card-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $berita['date'] }}
                        </span>
                        <a href="#" class="berita-card-link">Baca <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="berita-no-result" id="beritaNoResult">
            <i class="bi bi-search" style="font-size:2rem; color:#ccc;"></i>
            <p class="mt-2">Tidak ada berita yang cocok dengan pencarian Anda.</p>
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script>
// Toggle profil read more
function toggleProfil(btn) {
    const short = document.getElementById('profilShort');
    const span = btn.querySelector('span');
    setTimeout(() => {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        if (expanded) {
            short.style.display = 'none';
            span.textContent = 'Tutup';
        } else {
            short.style.display = 'block';
            span.textContent = 'Baca Selengkapnya';
        }
    }, 50);
}

// Toggle show more
function toggleShowMore(btn, section) {
    const span = btn.querySelector('span');
    setTimeout(() => {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        if (expanded) {
            span.textContent = 'Tutup';
        } else {
            span.textContent = 'Lihat Selengkapnya';
        }
    }, 50);
}

// Berita search filter
function filterBerita() {
    const query = document.getElementById('beritaSearch').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#beritaGrid .berita-card');
    const noResult = document.getElementById('beritaNoResult');
    let found = 0;
    
    cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const desc = card.getAttribute('data-desc') || '';
        if (title.includes(query) || desc.includes(query)) {
            card.style.display = '';
            found++;
        } else {
            card.style.display = 'none';
        }
    });

    noResult.classList.toggle('active', found === 0 && query.length > 0);
}
</script>
@endpush