@extends('layouts.app')
@section('title', 'Product Detail List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="d-flex justify-content-between card-header w-100">

                                <div class="">
                                    <h5 class="card-title mb-0 fw-bold text-black"
                                        style="font-size: 18px;
                                    font-weight: bold !important;
                                    text-transform: uppercase;">
                                        Customer Detail</h5>
                                </div>
                                <div class="">
                                    <a target="_blank" class="mx-2" href="{{ route('order.DetailPDF', $id) }}"
                                        title="Pdf Details">
                                        <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    </a>
                                    <a href="{{ route('order.pending') }}" class="btn btn-sm btn-primary mx-2">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="2%">Name</th>
                                            <th width="2%">Mobile</th>
                                            <th width="2%">Email</th>
                                            <th width="2%">Address</th>
                                            <th width="2%">City</th>
                                            <th width="2%">Pincode</th>
                                            <th width="2%">State</th>
                                            <th width="2%">Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td>{{ $data->shipping_cutomerName }}</td>
                                            <td>{{ $data->shipping_mobile }}</td>
                                            <td>{{ $data->shipping_email }}</td>
                                            <td>{{ $data->shiiping_address1 . ',' . $data->shiiping_address2 }}</td>
                                            <td>{{ $data->shipping_city ?? '-' }}</td>
                                            <td>{{ $data->shipping_pincode }}</td>
                                            <td>{{ $data->stateName }}</td>
                                            <td>{{ $data->country }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card">
                            <div class="d-flex justify-content-start card-header">
                                <h5 class="card-title mb-0 fw-bold text-black"
                                    style="font-size: 18px;
                                font-weight: bold !important;
                                text-transform: uppercase;">
                                    Product Detail</h5>
                            </div>
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th width="5%">Product Name</th>
                                            <th width="3%">Photo</th>
                                            <th width="1%">Size</th>
                                            <th width="1%">Qty</th>
                                            <th width="1%">Rate</th>
                                            <th width="1%">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1;
                                        $iTotal = 0;

                                        ?>
                                        @foreach ($detail as $details)
                                            <tr class="text-center"
                                                style="<?= $details->isRefund == 1 ? 'background: #f96767;color: white;' : '' ?>">
                                                <td>{{ $i }}</td>
                                                <td>{{ $details->productname }}</td>
                                                <td>
                                                    <a target="_blank"
                                                        href="{{ asset('/uploads/product/yhumbnail/') . '/' . $details->photo }}">
                                                        <img width="50" height="50"
                                                            src="{{ asset('uploads/product/thumbnail/') . '/' . $details->photo }}">
                                                    </a>
                                                </td>
                                                <td>{{ $details->product_attribute_qty . ' (' . $details->name . ')' }}
                                                </td>
                                                <td>{{ $details->quantity }}</td>
                                                <td>{{ $details->rate }}</td>
                                                <td class="text-center">Rs.{{ $details->amount }}</td>
                                            </tr>
                                            <?php $i++; ?>

                                            <?php
                                            $Amount = $details->amount;
                                            $iTotal = $iTotal * 1 + $Amount * 1;
                                            ?>
                                        @endforeach
                                        <?php
                                        $total = $iTotal * 1;
                                        ?>

                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">Total:- &nbsp;</th>
                                            <th class="text-center">Rs.{{ $total }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">Discount:- &nbsp;</th>
                                            <th class="text-center">Rs.{{ $data->discount ?? 0 }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">Net Amount:- &nbsp;</th>
                                            <th class="text-center">Rs.{{ $data->netAmount }}</th>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection
