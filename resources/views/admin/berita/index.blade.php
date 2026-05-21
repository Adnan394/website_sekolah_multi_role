@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Data Berita</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Berita</li>
    </ol>
    </nav>
</div>

<a href="{{ route('berita.create') }}" class="btn btn-danger mb-3">
    Tambah Berita
</a>

<div class="card">
<div class="card-body mt-3">
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Thumbnail</th>
            <th>Judul</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img width="80" src="{{ asset('uploads/berita/'.$item->thumbnail) }}">
            </td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->slug }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->tanggal_publish }}</td>
            <td>
                <a href="{{ route('berita.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('berita.destroy',$item->id) }}" method="POST" style="display:inline">
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

</main>
@endsection