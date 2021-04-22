@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif --}}
                        <div class="card-header">
                            <h3 class="card-title">List Invoices</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:10%;">NO</th>
                                        <th class="text-center" style="width:15%;">Invoice Number</th>
                                        <th class="text-center" style="width:15%;">Harga</th>
                                        <th class="text-center" style="width:15%;">Status</th>
                                        <th class="text-center" style="width:15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $order->invoice_number }}</td>
                                            <td class="text-center">{{ $order->total }}</td>
                                            <td class="text-center">
                                                @switch($order->status)
                                                    @case('waiting')
                                                        <span class="badge badge-secondary">{{ $order->status }}</span>
                                                        @break
                                                    @case('process')
                                                        <span class="badge badge-warning">{{ $order->status }}</span>
                                                        @break
                                                    @case('done')
                                                        <span class="badge badge-success">{{ $order->status }}</span>
                                                        @break
                                                    @case('denied')
                                                        <span class="badge badge-danger">{{ $order->status }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group d-flex">
                                                    <a href="{{ route('invoices.show', ['order' => $order]) }}" class="btn btn-secondary btn-xs btn-info w-100">
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <h5 class="text-center">No order available.</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $orders->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
