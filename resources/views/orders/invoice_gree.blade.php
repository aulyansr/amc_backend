<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        body {
            font-family: "Roboto", sans-serif;
        }

        p {
            font-family: "Roboto", sans-serif;
        }

        h1,
        h2 {
            font-family: "Roboto", sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .page_break {
            page-break-before: always;
        }


        th,
        td {

            text-align: left;
            font-family: "Roboto", sans-serif;
            vertical-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        table tr td div {
            text-align: center;
        }

        table tr td img {
            width: 100%;
            height: auto;
        }

        table tr td h1 {
            font-family: "Roboto", sans-serif;
            font-size: 25px;
        }

        table thead th {
            text-align: center;
            font-family: "Roboto", sans-serif;
        }

        #grand_title {
            text-align: right;
        }

        .signature {
            text-align: right;
            margin-top: 130px;
        }


        .table-order,
        .table-order th,
        .table-order td {
            border: 1px solid gray;
        }

        .table-order th,
        .table-order td {
            padding: 10px;
        }

        .table-order thead {
            text-align: center;
        }

        .table-order {
            border-collapse: collapse;
        }

        .table-pay th,
        .table-pay td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <table>
        <tr style="border-bottom: 2px solid #258BC3;vertical-align:center">
            <td style="vertical-align:middle; width:30%">
                <img src="{{ public_path('assets/images/Logo AMC Fixed.png') }}" alt="AMC">
            </td>
            <td style="text-align: left; vertical-align:center;padding-left: 20px">
                <p style="margin-bottom:5px;font-size: 25px;font-weight:700">AIRCON MANAGEMENT COMPANY</p>
                <p>Jalan Taman Daan Mogot Raya No. 17 Tanjung Duren Utara, Grogol Petamburan, Jakarta Pusat 11470</p>
            </td>
        </tr>
    </table>
    <h1 style="text-align: center">INVOICE</h1>
    <table style="width: 80%">
        <tr>
            <th style="width: 20%">No Invoice</th>
            <th style="width: 5%">:</th>
            <td style="width: 65%">
                {{ $orders[0]->id }}/AMC/GREE/{{ monthToRoman(date('F', strtotime($orders[0]->booked_date))) }}/{{ date('Y', strtotime($orders[0]->booked_date)) }}
            </td>
        </tr>
        <tr>
            <th>Invoice Date</th>
            <th>:</th>
            <td>{{ date('d F Y ', strtotime($orders[0]->booked_date)) }}</td>
        </tr>
        <tr>
            <th>No SPK</th>
            <th>:</th>
            <td>{{ $orders[0]->ref_no ? $orders[0]->ref_no : $orders[0]->order_code }}</td>
        </tr>
        <tr>
            <th>Customer</th>
            <th>:</th>
            <td>{{ $orders[0]->customer_b2b2c->nama }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <th>:</th>
            <td>{{ $orders[0]->address->address_detail }}</td>
        </tr>
    </table>

    <table class="table-order">
        <thead>
            <tr>
                <th>No.</th>
                <th>Description</th>
                <th>Model</th>
                <th>AC Qty</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        @php
            $grand_total = 0;
            $diskon = 0;
            $transport_fee = 0;
            $sub_total = 0;
            $index = 0;
        @endphp
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($orders as $order)
                @php
                    $grand_total += $order->grand_total;
                    $transport_fee += $order->transport_fee;
                    $rowspan = $order->service_counts->count();
                    $services = $order->service_counts;
                    $sub_total += $order->total_base_price;

                @endphp
                @foreach ($services as $key => $service)
                    <tr>
                        <td style="text-align: center">{{ $no++ }}</td>
                        <td>{{ $service['service_type'] }}</td>
                        <td>{{ $service['ac_name'] }}</td>
                        <td>{{ $service['count'] }}</td>

                        <td style="text-align: right">Rp. {{ thousand_separator($service['price']) }}</td>

                        <td style="text-align: right">Rp. {{ thousand_separator($service['sub_total']) }}</td>
                    </tr>
                @endforeach
                @foreach ($order->spare_part as $spare_part)
                    <tr>
                        <td style="text-align: center">{{ $no++ }}</td>
                        <td>{{ $spare_part->spare_part->spare_part_group->name }}</td>
                        <td>-</td>
                        <td>{{ $spare_part->quantity }}</td>
                        <td style="text-align: right">Rp. {{ thousand_separator($spare_part->base_price) }}</td>
                        <td style="text-align: right">Rp. {{ thousand_separator($spare_part->total_price) }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td style="text-align: center">{{ $no++ }}</td>
                <td>Transport</td>
                <td></td>
                <td>1 Job</td>

                <td style="text-align: right">Rp. {{ thousand_separator($transport_fee) }}</td>

                <td style="text-align: right">Rp. {{ thousand_separator($transport_fee) }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right;">Total</td>
                <td style="text-align: right">Rp. {{ thousand_separator($grand_total) }}</td>
            </tr>
        </tbody>
    </table>
    <p>Pembayaran dapat melalui Rekening :</p>
    <table style="width: 70%" class="table-pay">
        <tbody>
            <tr>
                <td style="width: 40%">Nama Bank</td>
                <td style="width: 2%">:</td>
                <td style="width: 58%">BCA</td>
            </tr>
            <tr>
                <td>Atas Nama</td>
                <td>:</td>
                <td>PT. Aircon Manajemen Corpora</td>
            </tr>
            <tr>
                <td>No Rekening</td>
                <td>:</td>
                <td>8650626738</td>
            </tr>
            <tr>
                <td colspan="3">Bukti Pembayaran Wajib Dikirimkan ke</td>
            </tr>
            <tr>
                <td>Whatsapp</td>
                <td>:</td>
                <td>0852-1063-2227</td>
            </tr>
        </tbody>
    </table>



    <div style="display: inline-block; text-align: right; width: 100%;">
        <div style="display: inline-block; width: 25%; text-align: center;">
            <p style="font-size: 18px; margin-bottom: 100px;">Head of Operation</p>
            <p style="font-size: 18px;">Ervan Sugiarto</p>
        </div>
    </div>

    <div class="page_break"></div>

    <h2>FOTO SPK</h2>

    <img src="{{ asset('storage/images/orders/work_order/' . $orders[0]->work_order) }}" alt="AMC" width="100%">


</body>

</html>
