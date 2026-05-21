@extends('layouts.admin')
@section('content')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Tugas Siswa</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Siswa</li><li class="breadcrumb-item active">Tugas Siswa</li></ol></nav>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <h3>{{ $submission->jadwalTugas->judul_tugas }} - {{ $submission->siswa->nama_lengkap }}</h3>

                <p>File Siswa: 
                @if($submission->file_upload)
                <a href="{{ Storage::url($submission->file_upload) }}" target="_blank">Download</a>
                @endif
                </p>

                <p>Link: <a href="{{ $submission->link_upload }}" target="_blank">{{ $submission->link_upload }}</a></p>

                <form action="{{ route('siswa-tugas.update', $submission) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nilai (maks {{ $submission->jadwalTugas->nilai_maksimal }})</label>
                        <input type="number" name="nilai" class="form-control" value="{{ $submission->nilai }}">
                    </div>
                    <div class="mb-3">
                        <label>Komentar</label>
                        <input type="text" name="komentar" class="form-control" value="{{ $submission->komentar }}">
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Penilaian</button>
                </form>
            </div>
        </div>
    </section>    
</main>
@endsection