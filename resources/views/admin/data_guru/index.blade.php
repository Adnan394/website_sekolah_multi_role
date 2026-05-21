@extends('layouts.admin')
@section('content')
<main id="main" class="main">
    
    <div class="pagetitle">
      <h1>Data Guru</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Data Guru</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data</h5>
              <a href="{{ route('data_guru.create') }}" class="btn btn-danger justify-content-end mb-3">Tambah Data Guru</a>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Posisi</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tempat Lahir</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><img width="50px" src="{{ isset($item->master_user->foto) ? asset($item->master_user->foto) : asset('assets/img/defaultpp.webp') }}" alt=""></td>
                        <td>{{ $item->master_user->nama_lengkap }}</td>
                        <td>{{ $item->master_user->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->master_user->alamat }}</td>
                        <td>{{ $item->master_user->tempat_lahir }}</td>
                        <td>{{ $item->master_user->tanggal_lahir }}</td>
                        <td>
                            <a href="{{ route('data_guru.edit', $item->id) }}" class="btn btn-warning mb-2"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('data_guru.destroy', $item->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            {{-- <a href="" class="btn btn-danger"><i class="bi bi-trash"></i></a> --}}
                        </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </section>
</main>
@endsection