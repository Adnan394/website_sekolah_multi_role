@extends('layouts.app')

@section('content')

<style>
.hero {
    height: 90vh;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url("{{ asset('img/hero.png') }}");
    background-size: cover;
    background-position: center;
    color: white;
}

.section-title {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 40px;
}

.card-hover {
    transition: 0.3s;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Struktur organisasi tree */
.tree ul {
    padding-top: 20px;
    position: relative;
}

.tree li {
    float: left;
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
}

.tree li::before, .tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #ccc;
    width: 50%;
    height: 20px;
}

.tree li::after {
    right: auto;
    left: 50%;
    border-left: 2px solid #ccc;
}

.tree li:only-child::after, 
.tree li:only-child::before {
    display: none;
}

.tree li div {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 10px;
    background: white;
    display: inline-block;
}
</style>


{{-- HERO --}}
<section class="hero d-flex align-items-center">
    <div class="container text-center">
        <h1 class="fw-bold">SDN 3 KRENCENG</h1>
        <p>Menanamkan semangat belajar, membentuk generasi cerdas untuk masa depan yang gemilang</p>
    </div>
</section>


{{-- PROFIL --}}
<section class="container my-5">
    <h2 class="text-center section-title">PROFIL SEKOLAH</h2>

    <div class="row align-items-center">
        <div class="col-md-5">
            <img src="{{ asset($tentang->gambar ?? 'img/dummy.png') }}" class="img-fluid rounded">
        </div>
        <div class="col-md-7">
            <p style="text-align: justify">
                {!! Str::limit($tentang->tentang_kami ?? '', 500) !!}
            </p>
        </div>
    </div>
</section>


{{-- STRUKTUR ORGANISASI --}}
<section class="container my-5">
    <h2 class="text-center section-title">STRUKTUR ORGANISASI</h2>

    <div class="tree d-flex justify-content-center">
        <ul>
            @foreach($struktur as $item)
                <li>
                    <div>
                        <strong>{{ $item->nama }}</strong><br>
                        <small>{{ $item->jabatan }}</small>
                    </div>

                    @if($item->children->count())
                        <ul>
                            @foreach($item->children as $child)
                                <li>
                                    <div>
                                        <strong>{{ $child->nama }}</strong><br>
                                        <small>{{ $child->jabatan }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</section>


{{-- FASILITAS --}}
<section class="container my-5">
    <h2 class="text-center section-title">FASILITAS SEKOLAH</h2>

    <div class="row">
        @foreach($fasilitas as $item)
        <div class="col-md-4 mb-4">
            <div class="card card-hover text-center p-4">
                <h5>{{ $item->nama }}</h5>
            </div>
        </div>
        @endforeach
    </div>
</section>


{{-- PRESTASI --}}
<section class="my-5 bg-primary text-white py-5">
    <div class="container">
        <h2 class="text-center mb-5">PRESTASI SEKOLAH</h2>

        @foreach($prestasi as $item)
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <img src="{{ asset('uploads/prestasi/'.$item->gambar) }}" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <h4>{{ $item->title }}</h4>
                <p>{{ $item->created_at->format('d M Y') }}</p>
                <div>
                    {!! Str::limit($item->description, 200) !!}
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>


{{-- BERITA (biarkan dummy) --}}
<section class="my-5">
    <div class="container">
        <h2 class="text-center section-title">BERITA</h2>

        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('img/dummy.png') }}" class="img-fluid">
                <h5 class="mt-2">Pengumuman</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/dummy.png') }}" class="img-fluid">
                <h5 class="mt-2">Kegiatan Sekolah</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/dummy.png') }}" class="img-fluid">
                <h5 class="mt-2">Informasi</h5>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
        </div>
    </div>
</section>

@endsection