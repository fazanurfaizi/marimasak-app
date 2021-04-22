@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <form action="{{ route('products.update', ['product' => $product]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="nameproduct">Nama</label>
                                <input type="text" class="form-control" id="nameproduct" name="name" placeholder="Nama Produk" value="{{ $product->name }}">
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="descriptionproduct">Deskripsi </label>
                                <textarea class="form-control" id="descriptionproduct" name="description" placeholder="Deskripsi Produk">
                                    {{ $product->description }}
                                </textarea>
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                        <label for="priceproduct">Harga</label>
                                        <input type="number" class="form-control" id="priceproduct" name="price" placeholder="Harga Produk" value="{{ $product->price }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- select -->
                                    <div class="form-group {{ $errors->has('product_type_id') ? 'has-error' : '' }}">
                                        <label for="product_type_id" class="col-md-2 control-label">Category</label>
                                        <div class="col-md-12">
                                            {!! Form::select('product_type_id', $categories, $product->product_type_id, ['class' => 'form-control']) !!}
                                            <span class="help-block">
                                                <strong>{{ $errors->first('product_type_id') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Foto Produk</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image') }}">
                                    <label class="custom-file-label" for="image">{{ isset($product) ? $product->image : null }}</label>
                                </div>
                                <img src="{{ isset($product->image) ? $product->imageUrl : asset('images/placeholder.png') }}" alt="Image" id="image-preview" width="100%" height="384" class="mt-2">
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

<script>
    $(document).ready(function() {
        /**
         * Image preview
         */
        $("#image").on("change", function() {
            var fileName = $(this).val();
            $(this)
                .next(".custom-file-label")
                .html(fileName);
        });

        function readUrl(url) {
            if (url.files && url.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#image-preview").attr("src", e.target.result);
                };
                reader.readAsDataURL(url.files[0]);
            }
        }

        $("#image").change(function() {
            readUrl(this);
        });
        /**
         * End of Image preview
         */

        // Custom Console Log
        var css = "padding: 60px;text-align: center; background: transparent; color: green; font-size: 64px;"
        console.log("%cWelcome to mari masak", css);
    });
</script>
