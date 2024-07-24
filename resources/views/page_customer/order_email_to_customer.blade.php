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
            background-color: #0077B6;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #ffffff;
            font-size: 24px;
            margin-top: 0;
        }

        p {
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 10px;
        }

        a {
            color: #ffffff;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #258BC3;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <p>Dear {{ $data->phone_no }},</p>
        <p>Thank you for placing your order with us. We appreciate your business.</p>
        <p>Your order number is: {{ $data->pesan }}</p>
        <p>We will process your order and get back to you with the details and tracking information.</p>
        <p>If you have any questions or concerns, please don't hesitate to contact us at <a
                href="https://api.whatsapp.com/send?phone=6285210632227">AMC</a>.</p>
        <p>Best regards,</p>
        <p>Aircon Management Coporation</p>
    </div>
</body>

</html>
