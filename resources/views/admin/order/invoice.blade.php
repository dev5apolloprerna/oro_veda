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
        /* Gradient for table headers */
        background: linear-gradient(135deg, #2a7d3e, #8bc34a) !important;
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
        /* Gradient for highlighted cells */
        background: linear-gradient(135deg, #2a7d3e, #8bc34a) !important;
        color: white;
        font-weight: bold;
        text-align: center;
    }

    .totals {
        background: #f0f9f0;
        /* light soft background for totals */
        font-weight: 600;
    }

    .totals-row {
        /* Gradient for totals row */
        background: linear-gradient(135deg, #2a7d3e, #8bc34a) !important;
        font-weight: bold;
        color: white;
        border-top: 2px solid #603813;
    }
</style>

<!-- Header -->
<table style="width: 100%;">
    <tr class="no-border">
        <td class="header-logo">
            <img width="150" src="https://www.getdemo.in/oro_veda/assets/images/logo.png" alt="Logo">
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
        <td>{{ $data->shipping_city . ', ' . $data->shipping_pincode . ' - ' . $data->shiiping_state . ', ' . $data->countryName }}
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
        <th>Sr No</th>
        <th>Product Name</th>
        <th>Photo</th>
        <td>Size</td>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
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
            <td style="text-align: right;">{{ $details->currency }} {{ $details->amount }}</td>
        </tr>
        @php $iTotal += $details->amount; @endphp
    @endforeach

    <!-- Totals Section -->
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Amount</td>
        <td style="text-align: right;">{{ $details->currency }} {{ $iTotal }}</td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Discount</td>
        <td style="text-align: right;">
            {{ $data->discount ? $details->currency . $data->discount : '-' }}
        </td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Payable</td>
        <td style="text-align: right;">{{ $details->currency }} {{ $data->netAmount }}</td>
    </tr>
</table>
