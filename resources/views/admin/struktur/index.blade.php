@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Data Struktur Organisasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Struktur Organisasi</li>
    </ol>
    </nav>
</div>

<section class="section">
<div class="card">
<div class="card-body mt-3">

<a href="{{ route('struktur.create') }}" class="btn btn-danger mb-3">
    Tambah Data
</a>

<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#previewModal">
    Preview Hirarki
</button>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Parent</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img width="50"
                src="{{ $item->foto ? asset('uploads/struktur/'.$item->foto) : asset('assets/img/defaultpp.webp') }}">
            </td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jabatan }}</td>
            <td>{{ $item->parent->nama ?? '-' }}</td>
            <td>
                <a href="{{ route('struktur.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('struktur.destroy',$item->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
</div>
</section>

<!-- MODAL PREVIEW HIRARKI -->
<div class="modal fade" id="previewModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
    <h5>Preview Struktur Organisasi</h5>
</div>

<div class="modal-body">

<div id="treeArea">
@foreach($tree as $item)
    <ul>
        <li>
            <b>{{ $item->nama }}</b> - {{ $item->jabatan }}
            @if($item->children)
                @include('admin.struktur.tree',['children'=>$item->children])
            @endif
        </li>
    </ul>
@endforeach
</div>

<button onclick="downloadPDF()" class="btn btn-danger mt-3">
    Download PDF
</button>

</div>
</div>
</div>
</div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function downloadPDF() {
    var element = document.getElementById('treeArea');
    html2pdf().from(element).save('struktur_organisasi.pdf');
}
</script>

@endsection