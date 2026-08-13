@extends('layouts.app')

@section('content')

<style>
/* ── Berita Detail Page ── */
.berita-detail-hero {
    min-height: 340px;
    background: linear-gradient(160deg, rgba(26,5,5,0.88) 0%, rgba(137,10,10,0.7) 50%, rgba(26,5,5,0.92) 100%),
                url("{{ $berita->thumbnail ? asset('uploads/berita/'.$berita->thumbnail) : asset('img/dummy.png') }}");
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    position: relative;
    padding-top: 100px;
}
.berita-detail-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 120px;
    background: linear-gradient(to top, #f8f9fa, transparent);
    pointer-events: none;
}
.berita-detail-hero .container {
    position: relative;
    z-index: 2;
    padding-bottom: 50px;
}
.berita-detail-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
}
.berita-detail-breadcrumb a {
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: color 0.3s ease;
}
.berita-detail-breadcrumb a:hover {
    color: #fff;
}
.berita-detail-breadcrumb span {
    color: rgba(255,255,255,0.35);
    font-size: 0.85rem;
}
.berita-detail-breadcrumb .current {
    color: rgba(255,255,255,0.9);
    font-weight: 600;
}
.berita-detail-hero h1 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 16px;
    max-width: 700px;
}
.berita-detail-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
}
.berita-detail-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.7);
    font-size: 0.85rem;
    font-weight: 500;
}
.berita-detail-meta-item i {
    color: #c0392b;
    font-size: 0.95rem;
}

/* ── Content Area ── */
.berita-detail-content-wrap {
    padding: 40px 0 80px;
    margin-top: -30px;
    position: relative;
    z-index: 3;
}
.berita-detail-content-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
}
.berita-detail-thumbnail {
    width: 100%;
    max-height: 480px;
    object-fit: cover;
    display: block;
}
.berita-detail-body {
    padding: 40px 48px;
}
.berita-detail-body p {
    color: #444;
    font-size: 1rem;
    line-height: 1.9;
    margin-bottom: 18px;
}
.berita-detail-body img {
    max-width: 100%;
    border-radius: 12px;
    margin: 16px 0;
}
.berita-detail-body h2, .berita-detail-body h3 {
    color: #2c2c2c;
    font-weight: 700;
    margin-top: 28px;
    margin-bottom: 12px;
}

/* ── Share & Back ── */
.berita-detail-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 48px;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    border-radius: 0 0 20px 20px;
}
.berita-detail-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #890A0A;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    padding: 10px 24px;
    border: 2px solid #890A0A;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.berita-detail-back:hover {
    background: #890A0A;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(137,10,10,0.25);
}
.berita-detail-share {
    display: flex;
    align-items: center;
    gap: 8px;
}
.berita-detail-share span {
    font-size: 0.85rem;
    font-weight: 600;
    color: #888;
}
.berita-detail-share a {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(137,10,10,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #890A0A;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}
.berita-detail-share a:hover {
    background: #890A0A;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(137,10,10,0.3);
}

/* ── Berita Lainnya ── */
.berita-lainnya-section {
    padding: 0 0 80px;
}
.berita-lainnya-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #2c2c2c;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.berita-lainnya-title i {
    color: #890A0A;
}
.berita-lainnya-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.berita-lainnya-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.35s ease;
    border: 1px solid rgba(0,0,0,0.04);
    text-decoration: none;
    color: inherit;
    display: block;
}
.berita-lainnya-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 40px rgba(137,10,10,0.12);
    text-decoration: none;
    color: inherit;
}
.berita-lainnya-card-img {
    height: 180px;
    overflow: hidden;
}
.berita-lainnya-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.berita-lainnya-card:hover .berita-lainnya-card-img img {
    transform: scale(1.08);
}
.berita-lainnya-card-body {
    padding: 18px 20px;
}
.berita-lainnya-card-body h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #2c2c2c;
    margin-bottom: 6px;
    line-height: 1.4;
}
.berita-lainnya-card-body p {
    color: #888;
    font-size: 0.82rem;
    margin-bottom: 10px;
}
.berita-lainnya-card-body .date {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #aaa;
    font-size: 0.78rem;
    font-weight: 500;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .berita-detail-hero h1 { font-size: 1.5rem; }
    .berita-detail-body { padding: 24px 20px; }
    .berita-detail-actions { padding: 18px 20px; flex-direction: column; gap: 16px; }
    .berita-detail-hero { min-height: 280px; padding-top: 80px; }
}
</style>

{{-- Hero --}}
<section class="berita-detail-hero">
    <div class="container">
        <div class="berita-detail-breadcrumb">
            <a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Beranda</a>
            <span>/</span>
            <a href="{{ route('home') }}#berita">Berita</a>
            <span>/</span>
            <span class="current">{{ Str::limit($berita->judul, 40) }}</span>
        </div>
        <h1>{{ $berita->judul }}</h1>
        <div class="berita-detail-meta">
            @if($berita->penulis)
            <div class="berita-detail-meta-item">
                <i class="bi bi-person-fill"></i>
                {{ $berita->penulis }}
            </div>
            @endif
            <div class="berita-detail-meta-item">
                <i class="bi bi-calendar3"></i>
                {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="berita-detail-content-wrap">
    <div class="container">
        <div class="berita-detail-content-card">
            @if($berita->thumbnail)
                <img src="{{ asset('uploads/berita/'.$berita->thumbnail) }}" alt="{{ $berita->judul }}" class="berita-detail-thumbnail">
            @endif

            <div class="berita-detail-body">
                {!! $berita->konten !!}
            </div>

            <div class="berita-detail-actions">
                <a href="{{ route('home') }}#berita" class="berita-detail-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Berita
                </a>
                <div class="berita-detail-share">
                    <span>Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Berita Lainnya --}}
        @if($beritaLainnya->count() > 0)
        <div class="berita-lainnya-section" style="margin-top: 48px;">
            <h3 class="berita-lainnya-title"><i class="bi bi-newspaper"></i> Berita Lainnya</h3>
            <div class="berita-lainnya-grid">
                @foreach($beritaLainnya as $item)
                <a href="{{ route('berita.show.public', $item->slug) }}" class="berita-lainnya-card">
                    <div class="berita-lainnya-card-img">
                        @if($item->thumbnail)
                            <img src="{{ asset('uploads/berita/'.$item->thumbnail) }}" alt="{{ $item->judul }}">
                        @else
                            <img src="{{ asset('img/dummy.png') }}" alt="{{ $item->judul }}">
                        @endif
                    </div>
                    <div class="berita-lainnya-card-body">
                        <h5>{{ $item->judul }}</h5>
                        <p>{{ Str::limit(strip_tags($item->konten), 80) }}</p>
                        <div class="date">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
