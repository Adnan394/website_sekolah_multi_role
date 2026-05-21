@extends('layouts.admin')
@section('content')
<main id="main" class="main">
    
    <div class="pagetitle">
      <h1>Data User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Data User</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data</h5>

              <a href="{{ route('data_user.create') }}" class="btn btn-danger mb-3">
                Tambah Data User
              </a>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($data as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>

                    <!-- FOTO -->
                    <td>
                      <img width="50"
                        src="{{ $item->master_user && $item->master_user->foto 
                                ? asset('uploads/foto_user/'.$item->master_user->foto) 
                                : asset('assets/img/defaultpp.webp') }}">
                    </td>

                    <!-- MASTER USER -->
                    <td>{{ $item->master_user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ ucfirst($item->role) }}</td>

                    <td>
                      {{ ($item->master_user->jenis_kelamin ?? '') == 'P' 
                          ? 'Perempuan' 
                          : 'Laki-laki' }}
                    </td>

                    <!-- USER -->
                    <td>{{ $item->email }}</td>

                    <!-- MASTER USER -->
                    <td>{{ $item->master_user->alamat ?? '-' }}</td>
                    <td>{{ $item->master_user->tempat_lahir ?? '-' }}</td>
                    <td>{{ $item->master_user->tanggal_lahir ?? '-' }}</td>

                    <!-- AKSI -->
                    <td>
                      <a href="{{ route('data_user.edit', $item->id) }}" class="btn btn-warning mb-1">
                        <i class="bi bi-pencil"></i>
                      </a>

                      <form action="{{ route('data_user.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
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