@extends('front.layout.landing_page')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Peralatan')
@section('content')

<section class="container">
    <!-- Breadcrumb -->
    <nav class="pt-4 mt-lg-3" aria-label="breadcrumb">

    </nav>
    <!-- Page title + Filters -->
    <div class="d-lg-flex align-items-center justify-content-between py-4 mt-lg-2">
        <h1 class="me-3"></h1>
        <div class="d-md-flex mb-3">
            <div class="position-relative" style="min-width: 300px;">
                <form action="{{ route('tools') }}" method="GET">
                    <input type="text" name="search" class="form-control pe-5" placeholder="Cari Alat" value="{{ request('search') }}">
                    <i class="bx bx-search text-nav fs-lg position-absolute top-50 end-0 translate-middle-y me-3"></i>
                </form>
            </div>
        </div>
    </div>


    <!-- Courses grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4 mt-n2 mt-sm-0">
        @foreach($items as $item)
        <!-- Item -->
        <div class="col pb-1 pb-lg-3 mb-4">
            <article class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <a href="#" class="d-block position-absolute w-100 h-100 top-0 start-0"></a>
                    <img src="images/{{ $item->cover }}" class="card-img-top" alt="Image" style="width: 100%; height: 400px; object-fit: cover;">
                </div>
                <div class="card-body pb-3">
                    <h3 class="h5 mb-2">
                        <a href="#">{{ $item->name }}</a>
                    </h3>
                    <p class="fs-lg fw-semibold text-primary mb-0">{{ number_format($item->price, 0, ',', '.') }} per-Hari</p>
                </div>
                <div class="card-footer d-flex align-items-center fs-sm text-muted py-4">
                    <div class="d-flex align-items-center me-4" style="text-align: justify;">
                        {!! nl2br(e($item->description)) !!}
                    </div>
                </div>
            </article>
        </div>
        @endforeach
    </div>

</section>
<div >
    <div class="ms-auto">
        <div class="pagination pagination-lg d-flex justify-content-center">
            {{ $items->links() }}
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <p class="mb-0">Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} items</p>
    </div>
</div>


@endsection
