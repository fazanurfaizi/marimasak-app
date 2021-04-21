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
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Mari Masak
                                    <small class="float-right">{{ $invoice->created_at->format('d-m-Y') }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>Mari Masak</strong><br>
                                    Jl. Kliningan No.6, Turangga, Kec. Lengkong<br>
                                    Kota Bandung, Jawa Barat 40264<br>
                                    Phone: (022) 7303736<br>
                                    Email: marimasakproject@gmail.com
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                <strong>{{ $invoice->user->name }}</strong><br>
                                    Jl. H. Moch. Syahri GG. Puspa<br>
                                    Kota Bandung, 40195<br>
                                    Phone: {{ $invoice->user->phone }}<br>
                                    Email: {{ $invoice->user->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{ $invoice->invoice_number }}</b>
                                <br>
                                @switch($invoice->status)
                                    @case('waiting')
                                        <b>Status:</b> <span class="badge badge-secondary">{{ $invoice->status }}</span><br>
                                        @break
                                    @case('process')
                                        <b>Status:</b> <span class="badge badge-warning">{{ $invoice->status }}</span><br>
                                        @break
                                    @case('done')
                                        <b>Status:</b> <span class="badge badge-success">{{ $invoice->status }}</span><br>
                                        @break
                                    @case('denied')
                                        <b>Status:</b> <span class="badge badge-danger">{{ $invoice->status }}</span><br>
                                        @break
                                    @default
                                        <b>Status:</b> <span class="badge badge-secondary">{{ $invoice->status }}</span><br>
                                @endswitch
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>
                                    <tbody>
                                        @foreach ($invoice->orderDetails as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->product->description }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->quantity * $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ "Rp " . number_format($invoice->total, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping:</th>
                                            <td>{{ "Rp " . number_format(10000, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ "Rp " . number_format($invoice->total + 10000, 2, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row no-print">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                                <form class="mt-3" action="{{ route('invoices.update', ['order' => $invoice]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option {{ $invoice->status == 'waiting' ? 'selected' : '' }}>waiting</option>
                                            <option {{ $invoice->status == 'process' ? 'selected' : '' }}>process</option>
                                            <option {{ $invoice->status == 'done' ? 'selected' : '' }}>done</option>
                                            <option {{ $invoice->status == 'denied' ? 'selected' : '' }}>denied</option>
                                        </select>
                                        <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    </div>
                                    <button type="submit" class="btn btn-success float-right">
                                        <i class="far fa-credit-card"></i>
                                        Change Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
