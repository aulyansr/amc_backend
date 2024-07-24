<!DOCTYPE html>
<html>

<head>
    <style>
        /* CSS styles for the email design */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            font-size: 24px;
            margin-top: 0;
        }

        p {
            color: #666666;
            font-size: 16px;
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container">
            <h1>Permohonan Pesanan</h1>
            <p>Halo AMC,</p>
            <p>kita telah menerima permohonan pesanan dari {{ $data->customer->nama }}.</p>
            <p>Berikut adalah detail pesanan:</p>
            <ul>
                @php
                    $phoneNumber = $data->phone;
                    $firstNumber = substr($phoneNumber, 0, 1);
                    $newPhoneNumber = '62' . substr($phoneNumber, 1);
                @endphp
                <li>Nomor Pesanan: {{ $data->order_code }}</li>
                <li>Tanggal & Jam Pesanan: {{ date('D,d-m-Y H:i', strtotime($data->booked_date)) }}</li>
                <li>Nama Pelanggan: {{ $data->customer->nama }}</li>
                <li>Email: {{ $data->customer->email ? $data->customer->email : 'N/A' }}</li>
                <li>Nomor Telepon: <a
                        href="https://api.whatsapp.com/send?phone={{ $newPhoneNumber }}">{{ $data->customer->phone }}</a>
                </li>
                <li>Kendala: {{ $data->reason }}</li>
                <li>Layanan yang diminta:</li>
                <ul>
                    @foreach ($data->serviceCountsWithStatus as $service)
                        <li>{{ $service['service_name'] }} : {{ $service['count'] }} AC</li>
                    @endforeach
                </ul>
            </ul>
            <p>Silakan segera segera review pesanan dan proses sesuai kebijakan kita.</p>
            <p>Terima kasih,</p>
            <p>Aircon Management Coporate</p>
        </div>
    </div>
</body>

</html>
