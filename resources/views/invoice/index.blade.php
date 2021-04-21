@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Product Types</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Product Types</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-header">
                        <h3 class="card-title">List Product Types</h3>
                        <div class="card-tools">
                            <form method="get" role="form" class="input-group input-group-sm" style="width: 200px;">
                                <div class="input-group-append">
                                    <button type="reset" class="btn btn-default" onclick="clearSearch()">
                                        X
                                    </button>
                                </div>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request()->get('name') }}"
                                    class="form-control float-right"
                                    placeholder="Search"
                                >
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <a href="{{ route('product-types.create') }}">
                                    <i class="fas fa-plus m-2 ml-4 mr-4"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:10%;">ID</th>
                                    <th class="text-center" style="width:70%;">nama</th>
                                    <th class="text-center" style="width:20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    function clearSearch() {
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
            window.location = "{{ route('product-types.index') }}";
        }
    }

    function deleteProductType(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will delete this',
            icon: 'warning',
            confirmButtonText: 'Cool',
            showCancelButton: true,
        }).then(function(confirm) {
            if(confirm.isConfirmed) {
                swal.fire({
                    title: "Delete Successfully",
                    message: "You canceled to delete this",
                    icon: 'success',
                    time: 200
                }).then(function() {
                    $(`#productType-delete-${id}`).submit();
                })
            } else {
                swal.fire(
                    "Canceled",
                    "You canceled to delete this",
                    "error"
                );
            }
        })
    }
</script>
