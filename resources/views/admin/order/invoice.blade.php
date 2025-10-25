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
        background-color: #2a7d3e !important;
        /* Dark green */
        color: #fff !important;
    }

    .highlight,
    .totals-row {
        background-color: #4caf50 !important;
        /* Medium green */
        color: white !important;
        font-weight: bold;
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

    .totals {
        background-color: #eaf6ea !important;
        /* very light green */
        font-weight: 600;
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
        @if ($data->shiiping_address2)
            <td>{{ $data->shiiping_address2 }}</td>
        @else
            <td>
                {{ $data->shipping_city . ', ' . $data->countryName }}
            </td>
        @endif
    </tr>
    <tr>
        <td>Gujarat – 380028</td>
        @if ($data->shiiping_address2)
            <td>
                {{ $data->shipping_city . ', ' . $data->shipping_pincode . ' - ' . $data->shiiping_state . ', ' . $data->countryName }}
            </td>
        @else
            <td>
                {{ $data->shiiping_state . ' - ' . $data->shipping_pincode }}
            </td>
        @endif
    </tr>

    @if ($data->couriername || $data->docketNo)
        <tr>
            <td style="font-weight: 600;">Courier & Tracking No.</td>
            <td>{{ $data->couriername . ' - ' . $data->docketNo }}</td>
        </tr>
    @endif

    @if ($data->shipping_mobile || $data->shipping_mobile1)
        <tr>
            <td style="font-weight: 600;">Mobile No.</td>
            <td>
                @if ($data->shipping_mobile)
                    {{ $data->shipping_mobile }}
                @else
                    -
                @endif
            </td>
        </tr>
    @endif
</table>


<!-- Product Table -->
<table style="width: 100%; margin-top: 10px;">
    <tr>
        <th>Sr No</th>
        <th>Product Name</th>
        <th>Photo</th>
        <th>Size</th>
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
            <td style="text-align: center;">{{ $details->currency }}{{ number_format($details->rate, 2) }}</td>
            <td style="text-align: right;">{{ $details->currency }} {{ number_format($details->amount, 2) }}</td>
        </tr>
        @php $iTotal += $details->amount; @endphp
    @endforeach

    <!-- Totals Section -->
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Amount</td>
        <td style="text-align: right;">{{ $details->currency }} {{ number_format($iTotal, 2) }}</td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Discount</td>
        <td style="text-align: right;">
            {{ $data->discount ? $details->currency . number_format($data->discount, 2) : '-' }}
        </td>
    </tr>
    <tr class="totals-row">
        <td colspan="5"></td>
        <td style="text-align: center;">Net Payable</td>
        <td style="text-align: right;">{{ $details->currency }} {{ number_format($data->netAmount, 2) }}</td>
    </tr>
</table>
