<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .fs-12 {
            font-size: 12px;
        }

        @page {
            margin-top: 340px;
        }

        header {
            position: fixed;
            top: -250;
            left: 0;
            right: 0;
            padding: 10px;

        }

        .text-center {
            text-align: center
        }

        .text-left {
            text-align: left
        }



        .wrap-table {
            word-wrap: break-word;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 2px 20px;
        }

        table {
            border-collapse: collapse;
        }

        .ml-20 {
            margin-left: 20px;
        }

        img {
            width: 250px;
        }

        .w-20 {
            width: 20px;
        }
    </style>
</head>

<body>
    <header>
        <table class="fs-12">
            <tr>
                <th class="text-left">Nama AC</th>
                <td class="text-center"><b>PT AMC INDONESIA</b></td>
            </tr>
            <tr>
                <th class="text-left">Tanggal Invoice</th>
                <td class="text-center">{{ date('d-m-Y', strtotime(now())) }}</td>
            </tr>
            <tr>
                <th class="text-left">Nomor Invoice</th>
                <td class="text-center">{{ $orders->order->order_code }}</td>
            </tr>
            <tr>
                <th class="text-left">No SPK / WO</th>
                <td class="text-center">{{ $orders->order->ref_no }}</td>
            </tr>
            <tr>
                <th class="text-left">Jenis Servis</th>
                <td class="text-center"> {{ $orders->service->name }}</td>
            </tr>
            <tr>
                <th class="text-left">Nomor Seri AC</th>
                <td class="text-center">{{ $orders->master_ac->ac->acFullName }}</td>
            </tr>

        </table>

        <table class="fs-12">
            <tr>
                <th>TIPE AC</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>SERIES AC</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>TIPE UNIT</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>PK</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>TEGANGAN</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>WATT</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>WATT</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>DIAMETER LUAR PIPA CAIRAN</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>DIAMETER LUAR PIPA GAS</th>
                <td class="text-center"></td>
            </tr>
            <tr>
                <th>TANGGAL PRODUKSI AC</th>
                <td class="text-center"></td>
            </tr>

        </table>
    </header>
    <main class="body">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Sebelum</th>
                    <th>Sesudah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attachment as $a)
                    @php
                        $before = App\Models\OrderDetailAttachment::where('order_detail_id', $orders->id)
                            ->where('attachment_id', $a->attachment_id)
                            ->where('notes', 'before')
                            ->get();
                        $after = App\Models\OrderDetailAttachment::where('order_detail_id', $orders->id)
                            ->where('attachment_id', $a->attachment_id)
                            ->where('notes', 'after')
                            ->get();
                    @endphp
                    <tr>
                        <td class="w-20">{{ $a->attachment_item->title }}</td>
                        @if (!empty($before))
                            <td @if ($a->attachment_item->row_count == 1) colspan="2" @endif>
                                @foreach ($before as $attachment_before)
                                    <img width="100px" height="100px"
                                        src="{{ asset("storage/images/orders/location/$attachment_before->image") }}"
                                        alt="small logo">
                                @endforeach
                            </td>
                        @endif
                        @if (!empty($after) && $a->attachment_item->row_count > 1)
                            <td>
                                @foreach ($after as $attachment_after)
                                    <img width="100px" height="100px"
                                        src="{{ asset("storage/images/orders/location/$attachment_after->image") }}"
                                        alt="small logo">
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
    </main>
</body>

</html>
