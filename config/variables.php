<?php
//$environment = app()->environment();
$environment = env('APP_ENV');

if($environment == 'production'){
    return [
        'fcm_key' => 'AAAArEqP73A:APA91bFJbvpYYaASfyfPtbSIUPB6hmuBK8iOsUm2ivIPwU8g7LJJuToxK2DHGo2Ur7J4bNmu7Z92MerMzO9QXhS9fsbvgzpTPUmTbGM6VH0Zx4NOMI4lA0dQiC-PjzhIQ9dBq81dbkDc',
        'fazpass_key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZGVudGlmaWVyIjoxODZ9.Kwma0Tt3YvBt9SM7WNRETFHjk1-PkER1gIHhpc1QIC4',
        'fazpass_url' => 'https://api.fazpass.com',
        'fazpass_gateway' => '5b778e90-a121-4286-bee5-baefebe9f5d7',
        'fazpass_gateway_citcall' => 'a7009931-9681-457c-b9b1-e231bdee9d49',
        'fazpass_gateway_ims' => '4594b853-1c0c-4985-957d-74344eb559aa',
        'fazpass_endpoin_sms' => '/v1/message/send',
        'fazpass_endpoin_wa' => '/v1/otp/generate',

        //OTP SMS
        'fazpass_otp_sms_ims' => '8142b418-830a-4004-8f20-e55e1c24c7fd',
        'fazpass_endpoin_sms_ims' => '/v1/otp/generate',

        //OTP WA
        'fazpass_otp_wa_gushup' => '30b7b968-e5d1-42ba-831f-8a72a61542c5',
        'fazpass_endpoin_wa_gushup' => '/v1/otp/generate',
    ];
} else {
    return [
        'fcm_key' => 'AAAArEqP73A:APA91bFJbvpYYaASfyfPtbSIUPB6hmuBK8iOsUm2ivIPwU8g7LJJuToxK2DHGo2Ur7J4bNmu7Z92MerMzO9QXhS9fsbvgzpTPUmTbGM6VH0Zx4NOMI4lA0dQiC-PjzhIQ9dBq81dbkDc',
        'fazpass_key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZGVudGlmaWVyIjoxODZ9.Kwma0Tt3YvBt9SM7WNRETFHjk1-PkER1gIHhpc1QIC4',
        'fazpass_url' => 'https://api.fazpass.com',
        'fazpass_gateway' => '5b778e90-a121-4286-bee5-baefebe9f5d7',
        'fazpass_gateway_citcall' => 'a7009931-9681-457c-b9b1-e231bdee9d49',
        'fazpass_gateway_ims' => '4594b853-1c0c-4985-957d-74344eb559aa',
        'fazpass_endpoin_sms' => '/v1/message/send',
        'fazpass_endpoin_wa' => '/v1/otp/generate',

        //OTP SMS
        'fazpass_otp_sms_ims' => '8142b418-830a-4004-8f20-e55e1c24c7fd',
        'fazpass_endpoin_sms_ims' => '/v1/otp/generate',

        //OTP WA
        'fazpass_otp_wa_gushup' => '30b7b968-e5d1-42ba-831f-8a72a61542c5',
        'fazpass_endpoin_wa_gushup' => '/v1/otp/generate',
    ];
}