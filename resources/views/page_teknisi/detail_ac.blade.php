@extends('layouts.screen_technician')
@section('css')
@endsection
@section('content')
<section class="content">
    <form>
        <div class="container">
            <h1 class="fw-100 fs-4 text-primary-blue mb-3">Tambah Detail AC</h1>
            <p class="text-primary-blue ">Detail AC</p>
            <div class="card card-homepage mb-5">
                <div class="card-body">

                    <div class="mb-3">
                        <label for="BrandAC" class="form-label">Pilih Brand AC</label>
                        <select class="form-select" aria-label="BrandAC" name="BrandAC">
                            <option selected>Pilih</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Sharp">Sharp</option>
                            <option value="Gree">Gree</option>
                            <option value="Gree">Daikin</option>
                            <option value="LG">LG</option>
                            <option value="PANASONIC">PANASONIC</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_ac" class="form-label">PRODUK SKU</label>
                        <input type="text" class="form-control" id="nama_ac"
                            placeholder="Input nama / seri AC exp: AH-A5BEY">
                    </div>

                    <div class="mb-3">
                        <label for="model_ac" class="form-label">Model AC</label>
                        <select class="form-select" aria-label="BrandAC" name="model_ac">
                            <option selected>Pilih</option>
                            <option value="Split Wall">Split Wall</option>
                            <option value="Central">Central</option>
                            <option value="Standing Floor">Standing Floor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="daya_pk" class="form-label">Daya PK</label>
                        <input type="text" class="form-control" id="daya_pk" placeholder="1, 1/2 PK">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_freon" class="form-label">Tipe Refrigrant</label>
                        <input type="text" class="form-control" id="jenis_freon" placeholder="R-32, R-34">
                    </div>



                </div>
            </div>
            <p class="text-primary-blue ">History Layanan</p>
            <div class="card card-homepage">
                <div class="card-body">

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Cuci AC</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Tambah Freon</label>
                    </div>

                    <button type="submit" class="btn btn-dark-blue w-100">Submit</button>

                </div>
            </div>
        </div>
    </form>
    <form id="logout-form" action="{{ route('technician.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</section>

@endsection
@section('js')

@endsection
