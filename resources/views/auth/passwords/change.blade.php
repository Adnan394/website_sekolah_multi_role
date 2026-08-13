@extends('layouts.admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Ubah Password</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Ubah Password</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Form Ubah Password</h5>

              @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('success') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif

              <form action="{{ route('password.update') }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="mb-3">
                      <label for="current_password" class="form-label">Password Saat Ini</label>
                      <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                      @error('current_password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label for="password" class="form-label">Password Baru</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                      @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                  </div>

                  <div class="text-end">
                      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Password</button>
                  </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
