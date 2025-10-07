<style>
    body {
        font-family: 'DejaVu Sans', sans-serif !important;
        margin: 0;
        padding: 0;
    }

    table,
    th,
    td {
        border: 1px solid #000 !important;
        border-collapse: collapse !important;
        padding: 8px !important;
    }

    th {
        background-color: #8A3C8B;
        /* Purple */
        color: white;
        text-align: center;
    }

    td {
        font-size: 13px;
    }

    .header-logo {
        text-align: center;
        padding: 10px;
    }

    .no-border td {
        border: none !important;
    }

    .highlight {
        background-color: #603813;
        color: white;
        font-weight: bold;
        text-align: center;
    }

    .totals {
        background-color: #f6f0e3;
        font-weight: 600;
    }

    .totals-row {
        background-color: #F8A43A;
        /* Orange */
        font-weight: bold;
        color: white;
        border-top: 2px solid #603813;
    }

    .totals {
        background-color: #FFF4E5;
        /* Optional soft background */
        font-weight: 600;
    }

    .highlight {
        background-color: #EB268F;
        /* Pink */
        color: white;
        font-weight: bold;
        text-align: center;
    }
</style>

<!-- Header -->
<table style="width: 100%;">
    <tr class="no-border">
        <td class="header-logo">
            <img width="150" src="https://www.sparshcosmo-group.com/assets/front/img/logo.png" alt="Logo">
        </td>
    </tr>
</table>

<!-- Address Section -->
<table style="width: 100%;">
    <tr>
        <td style="font-weight: 600;">Address:</td>
        <td>To,</td>
    </tr>
    <tr>
        <td>10, Shakti Appartment,</td>
        <td>{{ $data->shipping_cutomerName ?: $data->cutomerName }}</td>
    </tr>
    <tr>
        <td>Bhairavnath Road,</td>
        <td>{{ $data->shiiping_address1 }}</td>
    </tr>
    <tr>
        <td>Kankaria, Ahmedabad</td>
        <td>{{ $data->shiiping_address2 }}</td>
    </tr>
    <tr>
        <td>Gujarat – 380028</td>
        <td>{{ $data->shipping_city . ', ' . $data->shipping_pincode . ' - ' . $data->stateName . ', ' . $data->country }}
        </td>
    </tr>
    @if ($data->couriername || $data->docketNo)
        <tr>
            <td></td>
            <td>{{ $data->couriername . ' - ' . $data->docketNo }}</td>
        </tr>
    @endif
    <tr>
        <td></td>
        <td>
            @if ($data->shipping_mobile)
                {{ $data->shipping_mobile }}
            @elseif ($data->shipping_mobile1)
                {{ $data->shipping_mobile1 }}
            @else
                {{ $data->shipping_mobile . ', ' . $data->shipping_mobile1 }}
            @endif
        </td>
    </tr>
</table>

<!-- Product Table -->
<table style="width: 100%; margin-top: 10px;">
    <tr>
        <th style="background-color: #f8a43a; color: #ffffff;">Sr No</th>
        <th style="background-color: #f8a43a; color: #ffffff;">Product Name</th>
        <th style="background-color: #f8a43a; color: #ffffff;">Photo</th>
        <td style="background-color: #f8a43a; color: #ffffff;">Size</td>
        <th style="background-color: #f8a43a; color: #ffffff;">Qty</th>
        <th style="background-color: #f8a43a; color: #ffffff;">Rate</th>
        <th style="background-color: #f8a43a; color: #ffffff;">Amount</th>
    </tr>

    @php
        $i = 1;
        $iTotal = 0;
    @endphp
    @foreach ($detail as $details)
        <tr>
            <td style="text-align: center;">{{ $i++ }}</td>
            <td style="text-align: center;">{{ $details->productname }}</td>
            <td style="text-align: center;">
                <img width="48" height="48" src="{{ asset('uploads/product/thumbnail/' . $details->photo) }}">
            </td>
            <td style="text-align: center;">{{ $details->product_attribute_qty . ' (' . $details->name . ')' }}</td>
            <td style="text-align: center;">{{ $details->quantity }}</td>
            <td style="text-align: center;">{{ $details->rate }}</td>
            <td style="text-align: right;">Rs. {{ $details->amount }}</td>
        </tr>
        @php $iTotal += $details->amount; @endphp
    @endforeach

    <!-- Totals Section -->
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Amount</td>
        <td style="text-align: right;">Rs. {{ $iTotal }}</td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Discount</td>
        <td style="text-align: right;">
            {{ $data->discount ? 'Rs. ' . $data->discount : '-' }}
        </td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Payable</td>
        <td style="text-align: right;">Rs. {{ $data->netAmount }}</td>
    </tr>
</table>
