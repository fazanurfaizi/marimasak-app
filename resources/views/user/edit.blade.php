@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">TambahUser</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <form action="{{ route('users.update', ['user' => $user]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nameuser">Nama </label>
                                <input type="text" class="form-control" id="nameuser" name="name" placeholder="Nama User" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="emailuser">Email </label>
                                <input type="text" class="form-control" id="emailuser" name="email" placeholder="Email User" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="emailuser">Password </label>
                                <input type="password" class="form-control" id="emailuser" name="password" placeholder="Password User">
                            </div>
                            <div class="form-group">
                                <label for="phonenumber">No Handphone </label>
                                <input type="text" class="form-control" id="phonenumber" name="phone" placeholder="No Handphone User" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat </label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Alamat User" value="{{ $user->address }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Foto Produk</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image') }}">
                                        <label class="custom-file-label" for="image">{{ isset($user) ? $user->avatar : 'Choose file' }}</label>
                                    </div>
                                    <img src="{{ isset($user->avatar) ? $user->avatar_url : asset('images/placeholder.png') }}" alt="Image" id="image-preview" width="100%" height="384" class="mt-2">
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
