@extends('back.layout.dashboard')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Profile')
@section('content')
 <!-- Main body part  -->
 <div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            @include('back.alert')
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h2>Profile Information</h2>
                            <ul class="header-dropdown dropdown">
                                <li><a href="javascript:void(0);" class="full-screen"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mb-2 pt-1 mt-4"
                                    src="{{ !empty($profileData->profile) ? url('images/profile/' . $profileData->profile) : url('images/default-avatar.png') }} "
                                    height="100" width="100" alt="profile" />
                            </div>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group c_form_group">
                                        <label>Nama</label>
                                        <span>{{ $profileData->name }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group c_form_group">
                                        <label>Username</label>
                                        <span>{{ $profileData->username }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group c_form_group">
                                        <label>No Whatsapps</label>
                                        <span>0{{ $profileData->phone }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group c_form_group">
                                        <label>Alamat</label>
                                        <span>{{ $profileData->address }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary theme-bg gradient" data-toggle="modal" data-target="#modalEditProfile">
                                <i class="fa fa-edit"></i><span> Ubah Profile</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h2>Ubah Sandi</h2>
                        </div>
                        <div class="body">
                            <form action="{{ route('change.password') }}" method="POST">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <h6>Change Password</h6>
                                        <div class="form-group c_form_group">
                                            <label>Password Lama</label>
                                            <input type="password" name="current_password" class="form-control" placeholder="Password Lama" required>
                                        </div>
                                        <div class="form-group c_form_group">
                                            <label>Password Baru</label>
                                            <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required>
                                        </div>
                                        <div class="form-group c_form_group">
                                            <label>Confirm Password Baru</label>
                                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary theme-bg gradient">Update</button>
                                <button type="reset" class="btn btn-default">Batal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Modal Profile --}}
    <div class="modal fade" id="modalEditProfile" tabindex="-1" role="dialog" aria-labelledby="modalEditProfileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditProfileTitle">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('actionprofile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" value="{{ $profileData->name }}">
                        </div>
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" value="{{ $profileData->username }}">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">No Whatsapps</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" value="{{ $profileData->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Alamat</label>
                            <textarea class="form-control" id="editAddress" name="address" rows="4">{{ $profileData->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="editProfileImage">Profile Image</label>
                            <input type="file" class="form-control" id="editProfileImage" name="profile_image">
                            <div class="mt-2">
                                <img src="{{ !empty($profileData->profile) ? url('images/profile/' . $profileData->profile) : url('images/default-avatar.png') }}" height="100" width="100" alt="profile">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary theme-bg gradient">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.getElementById('editPhone').addEventListener('input', function() {
        let phone = this.value;

        // Remove leading '0' or '+62'
        if (phone.startsWith('0')) {
            phone = phone.substring(1);
        } else if (phone.startsWith('+62')) {
            phone = phone.substring(3);
        }

        // Ensure the phone number starts with '8'
        if (!phone.startsWith('8')) {
            phone = '8' + phone;
        }

        this.value = phone;
    });
</script>
@endsection
