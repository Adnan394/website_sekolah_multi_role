@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Data Prestasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Prestasi</li>
    </ol>
    </nav>
</div>
<section class="section">
<div class="card">
<div class="card-body mt-3">

<a href="{{ route('prestasi.create') }}" class="btn btn-danger mb-3">
    Tambah Prestasi
</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Title</th>
            <th>Description</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img width="80"
                src="{{ $item->gambar ? asset('uploads/prestasi/'.$item->gambar) : asset('assets/img/defaultpp.webp') }}">
            </td>
            <td>{{ $item->title }}</td>
            <td>{!! Str::limit($item->description, 50) !!}</td>
            <td>
                <a href="{{ route('prestasi.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('prestasi.destroy',$item->id) }}" method="POST" style="display:inline">
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