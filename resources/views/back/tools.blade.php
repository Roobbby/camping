@extends('back.layout.dashboard')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Data Alat')
@section('content')
 <!-- Main body part  -->
<div id="main-content">
    <div class="container-fluid">
        <!-- Page header section  -->
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            @include('back.alert')
                            <h2>Data Alat</h2>
                            <div class="mt-4">
                                <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#modalTambahData">
                                    <i class="fa fa-archive"></i><span> Tambah Data</span>
                                </button>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Alat</th>
                                            <th>Gambar</th>
                                            <th>Harga Sewa</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ Str::limit($item->name, 20) }}</td>
                                            <td>
                                                @if($item->cover)
                                                    <img src="images/{{ $item->cover }}" alt="{{ $item->name }}" class="rounded" width="100" height="70">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}/Hari</td>
                                            <td>{{ Str::limit($item->description, 50) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#modalViewData-{{ $item->id }}">
                                                    <i class="fa fa-eye"></i><span> View</span>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#modalEditData-{{ $item->id }}">
                                                    <i class="fa fa-edit"></i><span> Edit</span>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-round" data-toggle="modal" data-target="#modalHapusData-{{ $item->id }}">
                                                    <i class="fa fa-trash-o"></i><span> Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @foreach ($data as $item)
    <!-- Modal View Data -->
    <div class="modal fade" id="modalViewData-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalViewDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewDataTitle">View Data Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Alat:</strong> {{ $item->name }}</p>
                    <div>
                        <strong>Gambar:</strong><br>
                        @if($item->cover)
                            <img src="images/{{ $item->cover }}" alt="{{ $item->name }}" width="200">
                        @else
                            No Image
                        @endif
                    </div>
                    <p><strong>Harga Sewa:</strong> {{ number_format($item->price, 0, ',', '.') }}/Hari</p>
                    <p><strong>Deskripsi:</strong>  {!! nl2br(e($item->description)) !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="modalEditData-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDataTitle">Edit Data Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('data.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Alat</label>
                            <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="cover">Gambar</label>
                            <input type="file" class="form-control" name="cover">
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Sewa</label>
                            <input type="number" class="form-control" name="price" value="{{ $item->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3" required id="description"> {!! nl2br(e($item->description)) !!}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary theme-bg gradient">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Data -->
    <div class="modal fade" id="modalHapusData-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusDataTitle">Hapus Data Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data alat <strong>{{ $item->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('data.delete', $item->id) }}" method="POST">
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

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataTitle">Tambah Data Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('data.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Alat</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="cover">Gambar</label>
                            <input type="file" class="form-control" name="cover">
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Sewa</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary theme-bg gradient">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
