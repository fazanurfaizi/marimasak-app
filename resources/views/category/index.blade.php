<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marimasak</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('lte/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href=" {{ asset('lte/plugins/summernote/summernote-bs4.min.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        @include('./component/header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('./component/sidebar')

        <div class="content-wrapper">
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

            <!-- Main content -->
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
                                            @forelse ($productTypes as $type)
                                                <tr>
                                                    <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="text-center">{{ $type->name }}</td>
                                                    <td>
                                                        <div class="btn-group d-flex">
                                                            <a href="{{ route('product-types.edit', ['product_type' => $type]) }}" class="btn btn-secondary btn-xs btn-info w-100">
                                                                Edit
                                                            </a>
                                                            <a class="btn btn-secondary btn-xs btn-danger w-100" onclick="deleteProductType({{ $type->id }})">
                                                                Delete
                                                            </a>
                                                            <form id="productType-delete-{{ $type->id }}" action="{{ route('product-types.destroy', ['product_type' => $type]) }}" method="post" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        <h5 class="text-center">No Post available.</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {!! $productTypes->appends(['search' => request()->get('search')])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('./component/footer')

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
    </div>
</html>
