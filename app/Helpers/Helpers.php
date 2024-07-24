<?php

use App\Mail\NewOrderMail;
use App\Models\MasterCustomer;
use Hashids\Hashids;
use Illuminate\Support\Facades\Storage;
use App\Models\Po;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

function beauty_date($date = '')
{
    if ($date == '' || $date == '1970-01-01') {
        return '-';
    } else {
        return date("j M Y", strtotime($date));
    }
}

function beauty_datetime($date = '')
{
    return date("j M Y - H:i", strtotime($date));
}

function beauty_time($date = '')
{
    return date("H:i", strtotime($date));
}

function mysql_date($date = '')
{
    return date("Y-m-d", strtotime($date));
}

function mysql_fullDate($date = '')
{
    if ($date == '' || $date == null) {
        $new_date = '';
    } else {
        $new_date = date("Y-m-d H:i:s", strtotime($date));
    }
    return $new_date;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function formatDate($date = null, $format = 'Y-m-d h:i:s')
{
    if ($date) {
        $dateformat = new DateTime($date);
        $newDate    = $dateformat->format($format);
    } else {
        $newDate = null;
    }
    return $newDate;
}

function mysql_time($time = '')
{
    return date("H:i:s", strtotime($time));
}

function indonesia_date($date = '')
{
    return date("d-m-Y", strtotime($date));
}

function thousand_rupiah($input = 0)
{
    return "Rp " . number_format($input, 0, ",", ".");
}

function thousand_separator($input = 0)
{
    return number_format($input, 0, ",", ".");
}

function decimal($input = 0)
{
    if (is_numeric($input)) {
        return number_format($input, 2, ",", ".");
    } else {
        return $input;
    }
}
function resetNumberFormat($number)
{
    $data = str_replace('.', '', $number);
    return str_replace(',', '.', $data);
}
/**
 * function upload
 **/
function uploadFile($key, $path = 'public', $oldFile = null, $multiple = false, $initial = null)
{
    try {
        $file = request()->file($key);
        if ($multiple == true) {
            $file = $key;
        }
        $fileType = $file->getClientOriginalExtension();
        $fileName = sprintf('%s%s-%s%s.%s', $initial, auth()->id(), rand(11111, 99999), now()->timestamp, $fileType);
        if ($oldFile) {
            removeFile($oldFile, $path);
        }
        $file->storeAs($path, $fileName);
        return $fileName;
    } catch (\Exception $ex) {
        return redirect()->back()->withErrors(['danger' => $ex->getMessage()]);
    }
}

function removeFile($fileName, $storage = 'public')
{
    if (Storage::exists($storage)) {
        Storage::delete(sprintf('%s/%s', $storage, $fileName));
    }
}

function metadataFile($fileName, $type, $storage = 'public')
{
    if (Storage::exists($storage . $fileName)) {
        if ($type == 'size') {
            if ($fileName) {
                return formatSizeUnit(Storage::$type(sprintf('%s/%s', $storage, $fileName)));
            }
        }
        return Storage::$type(sprintf('%s/%s', $storage, $fileName));
    } else {
        return '';
    }
}
function formatSizeUnit($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}
function get_last_penomoran()
{
    $last = Po::latest()->first();
    $no = 1;
    $last_number = 1;
    if (!empty($last) && !empty($last->last_number)) {
        if (formatDate($last->created_at, 'm') == date('m')) {
            $no = $last->last_number + 1;
            $last_number = $last->last_number + 1;
        }
    }
    if ($no < 10) {
        $no = "00" . $no;
    } else if ($no >= 10 && $no < 100) {
        $no = "0" . $no;
    }
    $angka_romawi = bulan_angka_romawi(date('m'));
    $tahun = date('Y');
    $perusahaan = 'perusahaan';
    $nomorPo = $no . " / " . $perusahaan . " / " . $angka_romawi . " / " . $tahun;
    $result = [
        'nomorPo' => $nomorPo,
        'last_number' => $last_number
    ];
    return $result;
}
function bulan_angka_romawi($date)
{
    if ($date == '01') {
        return 'I';
    } else if ($date == '02') {
        return 'II';
    } else if ($date == '03') {
        return 'III';
    } else if ($date == '04') {
        return 'IV';
    } else if ($date == '05') {
        return 'V';
    } else if ($date == '06') {
        return 'VI';
    } else if ($date == '07') {
        return 'VII';
    } else if ($date == '08') {
        return 'VIII';
    } else if ($date == '09') {
        return 'IX';
    } else if ($date == '10') {
        return 'X';
    } else if ($date == '11') {
        return 'XI';
    } else if ($date == '12') {
        return 'XII';
    } else {
        return 'bulan tidak valid';
    }
}
function convertPhone($phone)
{
    return preg_replace('/^0/', '62', $phone);
}
function formatDatabaseDate($date)
{
    return date('Y-m-d', strtotime($date));
}
function formatIndonesiaDate($date)
{
    return date('d-m-Y', strtotime($date));
}

function arrayToString($array)
{
    return implode(',', $array);
}

function textInvoice($tagihan)
{
    $text = "Halo Ini Dari Admin AMC, Tagihan Order Anda Sebesar " . thousand_rupiah($tagihan) .
        "%0A silahkan transfer ke rekening 1111111 A/N AKKAKAK ";
    return $text;
}

function send_otp($phone = '', $content = '')
{
    // Credential
    $fazpass_key = config("variables.fazpass_key");
    $url = config("variables.fazpass_url");
    $fazpass_gateway = config("variables.fazpass_gateway_citcall");
    $fazpass_endpoin_wa = config("variables.fazpass_endpoin_sms");

    if ($phone == '') {
        return error("Nomor telepon tidak ditemukan");
    }

    $phone_number = preg_replace('/^0/', '62', $phone);

    $params = array(
        'gateway_key' => $fazpass_gateway,
        'phone' => $phone_number,
        'params' => array(
            array(
                "tag" => "parameter_dinamis",
                "value" => $content
            )

        )
    );

    //dd($params);

    $params_string = json_encode($params);

    $ch = curl_init();

    $url = $url . $fazpass_endpoin_wa;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . $fazpass_key,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params_string)
        )
    );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //execute post
    $request = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //dd($request);

    $result = json_decode($request, true);

    return true;

    info("Fazpass OTP Result");
    info($result);
    info("End Fazpass OTP Result");

    if ($result['status']) {
        $data = $result['data'];

        info($data);

        $customer->fazpass_otp_id = $data['id'];
        $customer->save();

        return true;
    }

    return false;
}

function otp_sms($phone = '', $content = '')
{
    // Credential
    $fazpass_key = config("variables.fazpass_key");
    $url = config("variables.fazpass_url");
    $fazpass_gateway = config("variables.fazpass_otp_sms_ims");
    $fazpass_endpoin_wa = config("variables.fazpass_endpoin_sms_ims");

    if ($phone == '') {
        return error("Nomor telepon tidak ditemukan");
    }

    $phone_number = preg_replace('/^0/', '62', $phone);

    $params = array(
        'gateway_key' => $fazpass_gateway,
        'phone' => $phone_number,
        'otp' => $content,
    );

    //dd($params);

    $params_string = json_encode($params);

    $ch = curl_init();

    $url = $url . $fazpass_endpoin_wa;

    //dd($url);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . $fazpass_key,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params_string)
        )
    );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //execute post
    $request = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //dd($request);

    $result = json_decode($request, true);

    return $result['data'];

    info("Fazpass OTP Result");
    info($result);
    info("End Fazpass OTP Result");

    if ($result['status']) {
        $data = $result['data'];

        info($data);
        $customer->fazpass_otp_id = $data['id'];
        $customer->save();

        return $result;
    }

    return false;
}

function otp_wa($phone = '')
{
    // Credential
    $fazpass_key = config("variables.fazpass_key");
    $url = config("variables.fazpass_url");
    $fazpass_gateway = config("variables.fazpass_otp_wa_gushup");
    $fazpass_endpoin_wa = config("variables.fazpass_endpoin_wa_gushup");

    if ($phone == '') {
        return error("Nomor telepon tidak ditemukan");
    }

    $phone_number = preg_replace('/^0/', '62', $phone);

    $params = array(
        'gateway_key' => $fazpass_gateway,
        'phone' => $phone_number,
        'params' => array(
            array(
                "tag" => "otp",
                //"value" => $content
            )

        )
    );

    $params_string = json_encode($params);

    $ch = curl_init();

    $url = $url . $fazpass_endpoin_wa;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . $fazpass_key,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params_string)
        )
    );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //execute post
    $request = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //dd($request);

    $result = json_decode($request, true);

    return true;

    info("Fazpass OTP Result");
    info($result);
    info("End Fazpass OTP Result");

    if ($result['status']) {
        $data = $result['data'];

        info($data);

        $customer->fazpass_otp_id = $data['id'];
        $customer->save();

        return true;
    }

    return false;
}

function hash_id($value)
{
    $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
    $hashedId = $hashids->encode($value);
    return $hashedId;
}
function send_mail_to_cs($order)
{
    try {

        Mail::to(["zendifirnanda05@gmail.com", "aulya@zipkos.id", "yohanes.firdian@acmaintenance.id"])->send(new NewOrderMail($order));
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
function convertDaysToMonthsWeeksDays($days)
{
    $months = floor($days / 30);
    $remainingDays = $days % 30;
    $weeks = floor($remainingDays / 7);
    $days = $remainingDays % 7;
    return array('months' => $months, 'weeks' => $weeks, 'days' => $days);
}

function getDistance($origin, $destination)
{
    $client = new Client();
    $apiKey = env('DISTANCE_MATRIX_KEY');
    $url = 'https://api.distancematrix.ai/maps/api/distancematrix/json?origins=' . $origin . '&destinations=' . $destination . '&key=' . $apiKey;

    $response = $client->request('GET', $url);
    $data = json_decode($response->getBody(), true);

    // Save the response to the database or cache
    // Example: Distance::create(['origin' => $origin, 'destination' => $destination, 'distance' => $data['rows'][0]['elements'][0]['distance']['value']]);

    return $data;
}
function getRandomColor()
{
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}


function monthToRoman($monthName)
{
    $monthMapping = [
        'January' => 'I',
        'February' => 'II',
        'March' => 'III',
        'April' => 'IV',
        'May' => 'V',
        'June' => 'VI',
        'July' => 'VII',
        'August' => 'VIII',
        'September' => 'IX',
        'October' => 'X',
        'November' => 'XI',
        'December' => 'XII',
    ];

    return $monthMapping[$monthName] ?? null;
}
