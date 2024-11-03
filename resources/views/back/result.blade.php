@extends('back.layout.dashboard')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Hasil Rekomendasi')
@section('content')
<div id="main-content">
    <div class="container-fluid">
        <!-- Page header section  -->
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            @include('back.alert')
                            <h2>Data Hasil Rekomendasi</h2>
                            <div class="mt-4">
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penyewa</th>
                                            <th>Nama Barang</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recommendations as $index => $recommendation)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $recommendation->renter_name }}</td>
                                            <td>
                                                @foreach($recommendation->recommendedItems as $item)
                                                    {{ $item->camping->name }} ({{ $item->quantity }} pcs) <br>
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($recommendation->total_price, 0, ',', '.') }} IDR</td>
                                            <td>
                                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalViewData-{{ $recommendation->id }}">Detail</a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusData-{{ $recommendation->id }}">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $recommendations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- modal view --}}
    @foreach($recommendations as $index => $recommendation)
    <div class="modal fade" id="modalViewData-{{ $recommendation->id }}" tabindex="-1" role="dialog" aria-labelledby="modalViewDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewDataTitle">Detail Rekomendasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Penyewa:</strong> {{ $recommendation->renter_name }}</p>
                    <p><strong>Total Harga:</strong> {{ number_format($recommendation->total_price, 0, ',', '.') }} IDR</p>
                    <h6><strong>Daftar Barang:</strong></h6>
                    <ul>
                        @foreach($recommendation->recommendedItems as $item)
                            <li>{{ $item->camping->name }} ({{ $item->quantity }} pcs) - {{ number_format($item->subtotal_price, 0, ',', '.') }} IDR</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- modal delete --}}
    @foreach($recommendations as $recommendation)
        <div class="modal fade" id="modalHapusData-{{ $recommendation->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusDataTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusDataTitle">Hapus Data Rekomendasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus rekomendasi untuk <strong>{{ $recommendation->renter_name }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('recommendation.delete', $recommendation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
