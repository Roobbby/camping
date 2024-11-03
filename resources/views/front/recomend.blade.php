@extends('front.layout.landing_page')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Rekomendasi')
@section('content')

<section class="container mb-5">
    <!-- Header and Form -->
    <nav class="pt-4 mt-lg-3" aria-label="breadcrumb"></nav>
    <div class="py-4 mt-lg-2 mb-1">
        <h1 class="me-3 mt-2">Halaman Rekomendasi</h1>
        <h3 class="me-3 mt-2">Masukkan Preferensi Anda agar Mendapatkan Rekomendasi Alat-Alat Camping Terbaik</h3>
    </div>

    <!-- Preference Form -->
    <div class="card" id="preferenceFormCard">
        <div class="card-body">
            <h5 class="card-title">Formulir Preferensi</h5>
            <p class="card-text fs-sm">Silakan isi Formulir berikut untuk Mendapatkan Rekomendasi Alat Camping Terbaik sesuai dengan Preferensi Anda.</p>
            <form id="preferenceForm" method="POST" action="{{ route('proces.recommendation') }}">
                @csrf
                <div class="row gx-3 gx-md-4 mt-n2 mt-sm-0">
                    <!-- Form Fields -->
                    <div class="col-12 mb-3">
                        <label for="number-of-people" class="form-label">Masukkan Jumlah Orang :</label>
                        <input class="form-control" type="number" id="number-of-people" name="number_of_people" value="1" min="1" max="100" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="terrain-select" class="form-label">Pilih Medan :</label>
                        <select class="form-select" id="terrain-select" name="terrain" required>
                            <option value="umum" selected>Umum</option>
                            <option value="gunung">Gunung</option>
                            <option value="pantai">Pantai</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="budget-input" class="form-label">Masukkan Jumlah Anggaran :</label>
                        <input class="form-control" type="text" id="budget-input" name="budget" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="number-of-days" class="form-label">Masukkan Jumlah Hari :</label>
                        <input class="form-control" type="number" id="number-of-days" name="number_of_days" value="1" min="1" max="7" required>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


</script>

@endsection
