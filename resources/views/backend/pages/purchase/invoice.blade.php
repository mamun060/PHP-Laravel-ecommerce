<html>

<head>
    <style>
        body {
            font-family: nikosh, sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE !important;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
        }

        .items td.cost {
            text-align: "."center;
        }
    </style>
</head>

<body>

    @php
        $due = $purchase->total_price - $purchase->total_payment;
    @endphp

    <htmlpageheader name="myheader">
        <table width="100%">
            <tr>
                <td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;"><img
                            width="180" height="80" style="padding:0px !important;"
                            src="https://themeshaper.net/img/logo.png" alt=""></span><br />House-07,Kobi faruk
                    soroni<br />Nikunja 2 ,Dhaka 1229<br /><span style="font-family:dejavusanscondensed;">&#9742;</span>
                    +880 1868-367706</td>
                <td style="text-align: right; width: 35%; min-width: 100px;vertical-align: bottom">
                    <p>Invocie No :</p>
                    <p>Purchase Date :</p>
                    @if($due <= 0)
                    <p>Payment Method :</p>
                    @endif 
                </td>
                <td style="width: calc(50% - 35%);text-align: right;vertical-align: bottom">
                    <p>{{ $purchase->invoice_no ?? '' }}</p>
                    <p>{{ $purchase->purchase_date ?? '' }}</p>
                    @if($due <= 0)
                    <p>{{ 'Cash' }} </p>
                    @endif 
                </td>
            </tr>
        </table>
    </htmlpageheader>

    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />

    <table width="100%" style="font-family: serif;" cellpadding="10">
        <tr>
            <td width="45%" style="padding-left: 0px !important;">
            <span style="font-size: 9pt; color: #555555; font-family: sans;font-weight:bold;">Purchase From:</span><br /><br />
            Supplier Name: {{ $purchase->supplier_name ?? 'N/A' }}<br />Supplier Phone: {{
                $purchase->supplier->supplier_phone ?? 'N/A' }}<br />Supplier Email: {{ $purchase->supplier->supplier_email ?? 'N/A' }}</td>
            <td width="10%">&nbsp;</td>
            <td width="45%" style="text-align: right; padding-right: 0px !important;">
                <div style="text-align: right;visibility:hidden;">x</div>
                <div style="text-align: right;visibility:hidden;">y</div>
                <div style="text-align: right;visibility:hidden;">z</div>
                <div style="text-align: right;visibility:hidden;">z</div>
                <div style="text-align: right">Date: {{ date('Y-m-d') }}</div>
            </td>
        </tr>
    </table>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
        <thead>
            <tr>
                <td width="5%">#SL</td>
                <td width="20%" align="left">Item Name</td>
                <td width="25%" align="left">Variant</td>
                <td width="15%">Unit</td>
                <td width="15%">Price</td>
                <td width="10%">Qty</td>
                <td width="15%" align="right">Amount</td>
            </tr>
        </thead>
        <tbody>

            @php
            $subSubtotal = 0;
            $totalDiscount = 0;
            @endphp
            @foreach ($purchase->purchaseProducts as $item)
            @php
            $subSubtotal    += $item->subtotal;
            $totalDiscount += $item->discount_price ?? 0;
            @endphp
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="left">
                    {{ $item->product_name ?? '' }}
                </td>
                <td align="left">
                    @if($item->product_colors)
                    Colors: {{ $item->product_colors ?? '' }} <br>
                    @endif
                    @if($item->product_sizes)
                    Sizes: {{ $item->product_sizes ?? '' }}
                    @endif
                </td>
                <td align="center">{{ $item->product_unit ?? 'N/A' }}</td>
                <td align="center">{{ $item->product_price ?? '0.0' }}</td>
                <td align="center">{{ $item->product_qty ?? '0' }}</td>
                <td align="right">{{ $item->subtotal }}</td>
            </tr>
            @endforeach

            <!-- END ITEMS HERE -->
            <tr>
                <td class="blanktotal" colspan="5" rowspan="4"></td>
                <td class="totals" colspan="1"><b>Subtotal:</b></td>
                <td class="totals cost">{{ $subSubtotal ?? 0 }}</td>
            </tr>
            <tr>
                <td class="totals" colspan="1"><b>Total:</b></td>
                <td class="totals cost"><b>{{ $subSubtotal - $totalDiscount }}</b></td>
            </tr>
            <tr>
                <td class="totals" colspan="1"><b>Paid:</b></td>
                <td class="totals cost">{{ $purchase->total_payment }}</td>
            </tr>
            <tr>
                <td class="totals" colspan="1"><b>Due:</b></td>
                <td class="totals cost"><b>{{ $subSubtotal - $purchase->total_payment }}</b></td>
            </tr>
        </tbody>
    </table>
    <br />

</body>

</html>