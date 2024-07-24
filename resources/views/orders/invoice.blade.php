<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .page-break {
            page-break-before: always;
        }

        table tr td div {
            text-align: center;
        }

        table tr td img {
            width: 200px;
        }

        table tr td h1 {
            text-align: center;
            font-size: 40px;
        }

        table thead th {
            text-align: center;
        }

        #grand_title {
            text-align: right;
        }

        .signature {
            text-align: right;
            margin-top: 130px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td width="30%">
                <div>
                    <img src="{{ public_path('assets/images/Logo AMC Fixed.png') }}" alt="AMC">

                </div>
            </td>
            <td>
                <h1>Invoice {{ $orders[0]->payment_status == 2 ? 'Pembayaran' : 'Penagihan' }}</h1>
            </td>
        </tr>
        <tr>
            <td>
                <b>Invoice : {{ $orders[0]->ref_no ? $orders[0]->ref_no : $orders[0]->order_code }}</b>
            </td>
            <td rowspan="2" style="text-align: right;">
                <b id="no_rek">BANK : BCA <br>NO REKENING : 8650626738 <br /> PT AIRCON MANAJEMEN CORPORA</br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Customer :
                    {{ $orders[0]->customer->type == 0 || $orders[0]->customer->type == null ? $orders[0]->customer->nama : $orders[0]->customer->company_name }}</b>
            </td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal dan Jam Pekerjaan</th>
                <th>Alamat</th>
                <th>Services</th>
                <th>@Rp BIAYA</th>
                <th>QTY</th>
                <th>Rp TOTAL BIAYA</th>
            </tr>
        </thead>
        @php
            $grand_total = 0;
            $diskon = 0;
            $transport_fee = 0;
            $sub_total = 0;
        @endphp
        <tbody>
            @foreach ($orders as $order)
                @php
                    $grand_total += $order->grand_total;
                    $diskon += $order->diskon;
                    $transport_fee += $order->transport_fee;
                    $rowspan = $order->service_counts->count();
                    $services = $order->service_counts;
                    $sub_total += $order->total_base_price;
                @endphp
                @foreach ($services as $key => $service)
                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ $rowspan }}" style="text-align: center;">{{ $loop->parent->iteration }}
                            </td>
                            <td rowspan="{{ $rowspan }}">
                                {{ date('D, d-F-Y / H:i', strtotime($order->booked_date)) }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $order->address->address_name }}</td>
                        @endif
                        <td>{{ $service['service_name'] }}</td>
                        <td>{{ thousand_separator($service['price']) }}</td>
                        <td>{{ thousand_separator($service['count']) }}</td>
                        <td>{{ thousand_separator((int) $service['count'] * (int) $service['price']) }}</td>

                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th id="grand_title" colspan="6">Sub Total</th>
                <th>{{ thousand_separator($sub_total) }}</th>
            </tr>
            <tr>
                <th id="grand_title" colspan="6">Biaya Transport</th>
                <th>{{ thousand_separator($transport_fee) }}</th>
            </tr>
            <tr>
                <th id="grand_title" colspan="6">Diskon</th>
                <th>{{ thousand_separator($diskon) }}</th>
            </tr>
            <tr>
                <th id="grand_title" colspan="6">Grand Total</th>
                <th>{{ thousand_separator($grand_total) }}</th>
            </tr>
            <tr>
                <td colspan="7">
                    Terimakasih atas kepercayaan Bapak/Ibu telah mempercayakan servis AC kepada AMC. Pembayaran harap
                    dilakukan paling lambat <b>1 hari</b> kalender setelah invoice ini diterbitkan.
                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: center;">
                    <b>GARANSI : 1 Bulan khusus Cleaning AC, Simpan invoice ini sebagai bukti untuk proses garansi</b>
                </td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
