@extends('layouts.admin')

@section('content')

<style>
.upload-wrapper {
    border: 2px dashed #ccc;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
}
input[type="file"] {
    display: none;
}
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tentang Kami</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tentang Kami</li>
        </ol>
        </nav>
    </div>


    <form action="{{ route('tentang_kami.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- UPLOAD GAMBAR -->
        <div class="mb-4 text-center">
            <label class="upload-wrapper">
                <p>Klik untuk upload gambar</p>
                <input type="file" name="gambar" id="inputGambar" accept="image/*">
            </label>

            <!-- PREVIEW -->
            <div class="mt-3">
                <img id="previewImg"
                    src="{{ isset($data->gambar) ? asset('uploads/tentang_kami/'.$data->gambar) : asset('assets/img/defaultpp.webp') }}"
                    style="max-width: 250px;">
            </div>
        </div>

        <!-- TEXT -->
        <div class="mb-3">
            <label class="form-label">Tentang Kami</label>
            <textarea class="form-control" name="tentang_kami" rows="5">{{ $data->tentang_kami ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-main">
            {{ $data ? 'Update' : 'Simpan' }}
        </button>
    </form>

</main>

<script>
const input = document.getElementById('inputGambar');
const preview = document.getElementById('previewImg');

input.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection