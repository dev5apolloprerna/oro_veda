@extends('layouts.app')

@section('title', 'Delivery List')

@section('content')




    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')



                <div class="row">
                    <div class="col-xxl-12">
                        <h5 class="mb-3"></h5>
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->

                                @include('admin.order.orderTab')



                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="PendingOrder" role="tabpanel">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">

                                                            <table id="scroll-horizontal" class="table nowrap align-middle"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="all">Sr.No</th>
                                                                        <th class="all">Order Date</th>
                                                                        <th class="all">Customer Name</th>
                                                                        <!--<th class="all">Email</th>-->
                                                                        <th class="all">Mobile</th>
                                                                        <th class="all">City</th>
                                                                        <th class="all">State</th>
                                                                        <th class="all">Pincode</th>
                                                                        <th class="all">Amount</th>
                                                                        <th class="all">Payment Status</th>
                                                                        <th class="all">Order Note</th>
                                                                        <!--<th class="all" colspan="10" >Action</th>-->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    ?>
                                                                    @foreach ($Pending as $pending)
                                                                        <?php
                                                                        $detail = App\Models\OrderDetail::select('orderdetail.*', DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'))
                                                                            ->orderBy('orderDetailId', 'DESC')
                                                                            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $pending->order_id])
                                                                            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
                                                                            ->join('product', 'orderdetail.productId', '=', 'product.productId')
                                                                            ->get();
                                                                        $Count = $detail->count() + 3;
                                                                        ?>
                                                                        <tr class="text-center"
                                                                            style='<?= $pending->orderNote != ''
                                                                            ? 'background: #f96767 !important;color: white  !important;'
                                                                            : '' ?>'>
                                                                            <td rowspan="{{ $Count }}">
                                                                                {{ $i + $Pending->perPage() * ($Pending->currentPage() - 1) }}
                                                                            </td>

                                                                            <td>{{ date('d-m-Y H:i:s', strtotime($pending->created_at)) }}
                                                                            </td>

                                                                            <td>{{ $pending->shipping_cutomerName }}</td>

                                                                            <!--<td>{{ $pending->shipping_email }}</td>-->
                                                                            <td>{{ $pending->shipping_mobile }}</td>
                                                                            <td>{{ $pending->shipping_city }}</td>
                                                                            <td>{{ $pending->stateName }}</td>
                                                                            <td>{{ $pending->shipping_pincode }}</td>

                                                                            <td>{{ $pending->netAmount }}</td>
                                                                            <td>
                                                                                @if ($pending->isPayment == 0)
                                                                                    Pending
                                                                                @elseif($pending->isPayment == 1)
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $pending->orderNote ?? '-' }}</td>
                                                                        </tr>



                                                                        <tr>
                                                                            <th colspan="2">PRODUCT</th>
                                                                            <th colspan="2">QTY</th>
                                                                            <th colspan="2">SIZE</th>
                                                                            <th colspan="2">PRICE</th>
                                                                            <th colspan="2">TOTAL</th>
                                                                        </tr>
                                                                        @foreach ($detail as $item)
                                                                            @php
                                                                                $ProductAttribute = App\Models\ProductAttributes::orderBy(
                                                                                    'id',
                                                                                    'desc',
                                                                                )
                                                                                    ->where([
                                                                                        'product_id' =>
                                                                                            $item->productId,
                                                                                        'id' => $item->size,
                                                                                    ])
                                                                                    ->first();
                                                                            @endphp
                                                                            <tr>
                                                                                <td colspan="2" class="image"
                                                                                    data-title="No"><img
                                                                                        src="{{ asset('Product/Thumbnail') . '/' . $item->photo }}"
                                                                                        width="50" height="50"
                                                                                        alt="#">
                                                                                </td>
                                                                                <!--<td class="product-des" data-title="Description">-->
                                                                                <!--    <p class="product-name"><a href="productlisting.php">{{ $item->name }}</a></p>-->
                                                                                <!--</td>-->
                                                                                <td colspan="2" class="qty text-right"
                                                                                    data-title="Qty">
                                                                                    {{ $item->quantity }}&nbsp;&nbsp;&nbsp;
                                                                                </td>
                                                                                <td colspan="2" class="qty text-center"
                                                                                    data-title="Qty">
                                                                                    {{ $ProductAttribute->product_attribute_size }}
                                                                                </td>
                                                                                <td colspan="2" class="price text-left"
                                                                                    data-title="Price">
                                                                                    <span> &#x20B9; {{ $item->rate }}
                                                                                    </span>
                                                                                </td>

                                                                                <td colspan="2"
                                                                                    class="total-amount text-right"
                                                                                    data-title="Total">
                                                                                    <span> &#x20B9;
                                                                                        {{ $item->rate * $item->quantity }}</span>
                                                                                </td>


                                                                            </tr>
                                                                        @endforeach

                                                                        <tr style='<?= $pending->orderNote != ''
                                                                            ? 'background: #f96767 !important;color: white  !important;'
                                                                            : '' ?>'>
                                                                            <!--<td>-</td>-->



                                                                            <td colspan="10" class="des-ll">
                                                                                <div class="d-flex justify-content-between">
                                                                                    <a class="" href="#"
                                                                                        data-bs-toggle="modal"
                                                                                        title="Dispatch"
                                                                                        data-bs-target="#showModal"
                                                                                        onclick="getEditData(<?= $pending->order_id ?>);">
                                                                                        <i
                                                                                            class="fa-solid fa-truck fa-lg"></i>
                                                                                        Dispatch Order
                                                                                    </a>

                                                                                    <a href="{{ route('order.statustocancel', $pending->order_id) }}"
                                                                                        onclick="return confirm('Are you Sure You wanted to Cancel?');"
                                                                                        class="mx-2" title="Cancel">
                                                                                        <i
                                                                                            class="fa-solid fa-xmark fa-xl"></i>
                                                                                        Cancel Order
                                                                                    </a>

                                                                                    <a class="mx-2"
                                                                                        href="{{ route('order.orderdetail', $pending->order_id) }}"
                                                                                        title="Details">
                                                                                        <i
                                                                                            class="fa-solid fa-circle-info fa-lg"></i>
                                                                                        View Order Details
                                                                                    </a>

                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DetailPDF', $pending->order_id) }}"
                                                                                        title="Pdf Details">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Order PDF
                                                                                    </a>

                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DispatchPDF', $pending->order_id) }}"
                                                                                        title="Dispatch Pdf Details">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Dispatch Order Sticker PDF
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style='<?= $pending->orderNote != ''
                                                                            ? 'background: #f96767 !important;color: white  !important;'
                                                                            : '' ?>'>
                                                                            <td style="height: 50px;" colspan="10"></td>
                                                                        </tr>
                                                                        <!--<tr style='<?= $pending->orderNote != '' ? 'background: #f96767 !important;color: white  !important;' : '' ?>'>-->
                                                                        <!--    <td style="border: none !important;" colspan="10">.</td>-->
                                                                        <!--</tr>-->
                                                                        <!--<tr style='<?= $pending->orderNote != '' ? 'background: #f96767 !important;color: white  !important;' : '' ?>'>-->
                                                                        <!--    <td style="border: none !important;" colspan="10">.</td>-->
                                                                        <!--</tr>-->
                                                                        <?php $i++; ?>
                                                                    @endforeach


                                                                </tbody>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $Pending->appends(request()->except('page'))->links() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Add Courier Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form method="POST" action="{{ route('order.statustodispatched') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="">

                    <div class="modal-body">

                        <div class="mb-3">
                            <span style="color:red;">*</span>Courier
                            <select name="courier" class="form-control" id="" required>
                                <option value="">Select Courier</option>
                                @foreach ($Courier as $courier)
                                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;">*</span>Docket No
                            <input type="text" class="form-control" name="docketNo" id="Editname"
                                placeholder="Enter Docket No" maxlength="100" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success" id="add-btn">Submit</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#startdatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });

        $(function() {
            $("#enddatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });
    </script>

    <script>
        function getEditData(id) {
            $('#order_id').val(id);
        }
    </script>
@endsection
