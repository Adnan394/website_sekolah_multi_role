@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Data Kurikulum</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Kurikulum</li>
    </ol>
    </nav>
</div>

<a href="{{ route('kurikulum.create') }}" class="btn btn-danger mb-3">
    Tambah Kurikulum
</a>

<div class="card">
<div class="card-body mt-3">
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Tahun Ajaran</th>
            <th>Status</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->tahun_ajaran }}</td>
            <td>{{ $item->status }}</td>
            <td>
                @if($item->file_pdf)
                    <a href="{{ asset('uploads/kurikulum/'.$item->file_pdf) }}" target="_blank">
                        Download
                    </a>
                @endif
            </td>
            <td>
                <a href="{{ route('kurikulum.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('kurikulum.destroy',$item->id) }}" method="POST" style="display:inline">
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