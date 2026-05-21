@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Data Fasilitas Sekolah</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Fasilitas Sekolah</li>
    </ol>
    </nav>
</div>
<section class="section">
<div class="card">
<div class="card-body mt-3">

<a href="{{ route('fasilitas.create') }}" class="btn btn-danger mb-3">
    Tambah Fasilitas
</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Fasilitas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>
                <a href="{{ route('fasilitas.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('fasilitas.destroy',$item->id) }}" method="POST" style="display:inline">
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

</main>
@endsection