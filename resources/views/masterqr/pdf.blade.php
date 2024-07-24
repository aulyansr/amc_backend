<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qr Generate PDF</title>
    <style>
        @page {
            /*The A4 paper size is 210 mm wide by 297 mm long*/
            size: 105mm 150mm;
        }

        body {
            font-family: Arial, sans-serif;
        }

        table {
            text-align: center;
            width: 100%;
            height: auto;
        }

        table td img {
            width: 70%;
        }

        table td h2 {
            color: #0077B6;
            margin: 0;
            padding: 0;
        }

        table td h4 {
            color: #0077B6;
            margin: 0;
            padding: 0;
        }

        table td p {
            color: #0077B6;
        }

        table td .qr_code {
            border: 2px solid #0077B6;
            padding: 10px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @foreach ($images as $i)
        <table style="text-align: center; width: 100%;">
            <tr>
                <td>
                    <img src="{{ public_path('assets/images/logo.png') }}" alt="amc">
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <img class="qr_code" src="data:image/png;base64, {!! base64_encode(
                        QrCode::size(300)->backgroundColor(255, 255, 255)->generate(route('landing.showdetailac', $i['url_unique'])),
                    ) !!} ">
                </td>
            </tr>
            <tr>
                <td>
                    <h2>Scan untuk Servis</h2>
                    <h4>{{ $i['qr_name'] }}</h4>
                    <p>www.acmaintenance.id</p>
                </td>
            </tr>
        </table>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
