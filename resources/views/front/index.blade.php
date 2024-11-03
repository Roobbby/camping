@extends('front.layout.landing_page')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Landing Page')
@section('content')

  <!-- Hero -->
  <section class="position-relative pt-md-3 pt-lg-5 mb-md-3 mb-lg-5">
    <div class="container position-relative zindex-5 pt-5">
      <div class="row mt-4 pt-5">
        <div class="col-xl-4 col-lg-5 text-center text-lg-start pb-3 pb-md-4 pb-lg-0">
          <h1 class="fs-xl text-uppercase"></h1>
          <h3 class="display-4 pb-md-2 pb-lg-4">Temukan Alat Alat Camping Anda</h3>
          <p class="fs-lg">Website ini bisa merekomendasikan pemilihan alat camping sesuai dengan kebutuhan Anda <a href="{{ route('recomends') }}" class="fw-medium">Klik sini.</a></p>
        </div>
      </div>
      <div class="d-none d-lg-block" style="margin-top: 80px;"></div>
      <div class="row align-items-end">
        <div class="col-lg-6 d-none d-lg-block">
          <img src="assets/img/fallback-image.jpg" class="rellax rounded-3" alt="Image" data-rellax-speed="1.35" data-disable-parallax-down="md">
        </div>
      </div>
    </div>
    <div class="d-none d-lg-block position-absolute top-0 end-0 w-50 d-flex flex-column ps-3" style="height: calc(100% - 50px);">
      <div class="w-50 h-100 overflow-hidden bg-position-center bg-repeat-0 bg-size-cover" style="background-image: url(assets/img/fallback-images.jpg); border-bottom-left-radius: .5rem;"></div>
    </div>
  </section>

  <section class="container py-5 mb-1 mb-md-4 mb-lg-5">
    <h2 class="h1 text-center pt-1 pb-4 mb-1 mb-lg-3">Alat Alat Camping</h2>
    <div class="position-relative px-xl-5">

        <!-- Slider prev/next buttons -->
        <button type="button" id="prev-news" class="btn btn-prev btn-icon btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-xl-inline-flex">
            <i class="bx bx-chevron-left"></i>
        </button>
        <button type="button" id="next-news" class="btn btn-next btn-icon btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-xl-inline-flex">
            <i class="bx bx-chevron-right"></i>
        </button>

        <!-- Slider -->
        <div class="px-xl-2">
            <div class="swiper mx-n2" data-swiper-options='{
                "slidesPerView": 1,
                "loop": true,
                "pagination": {
                    "el": ".swiper-pagination",
                    "clickable": true
                },
                "navigation": {
                    "prevEl": "#prev-news",
                    "nextEl": "#next-news"
                },
                "breakpoints": {
                    "500": {
                        "slidesPerView": 2
                    },
                    "1000": {
                        "slidesPerView": 3
                    }
                }
            }'>
                <div class="swiper-wrapper">
                    <!-- Item -->
                    @foreach($campingItems as $item)
                    <div class="swiper-slide h-auto pb-3">
                        <article class="card h-100 border-0 shadow-sm mx-2">
                            <div class="position-relative">
                                <!-- Pastikan path gambar benar -->
                                <div style="width: 370px; height: 370px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/' . $item->cover) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                            </div>
                            <div class="card-body pb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="fs-sm text-muted">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="h5 mb-0">
                                    <a href="#">{{ $item->name }}</a>
                                    <p>Rp {{ number_format($item->price, 0, ',', '.') }} per hari</p>

                                </h3>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination (bullets) -->
                <div class="swiper-pagination position-relative pt-2 pt-sm-3 mt-4"></div>
            </div>
        </div>
    </div>
</section>
<section class="container py-5 mb-5">
    <h2 class="h1 text-center pt-1 pb-4 mb-1 mb-lg-3">Lokasi Kami</h2>
    <div class="map-container" style="width: 100%; height: 400px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9552695927828!2d110.92756867482808!3d-7.470191892541486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1b84a9359e5b%3A0xdc2235c2f35066b2!2sBERKAH%20OUTDOOR45!5e0!3m2!1sid!2sid!4v1724762759714!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

@endsection
