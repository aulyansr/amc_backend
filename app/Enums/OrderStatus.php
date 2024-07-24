<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    /** Order Status */
    const DIBATALKAN = 0;
    const MENUNGGU_PEMBAYARAN = 1;
    const PEMBAYARAN_SELESAI = 2;
    const TEKNISI_DITUGASKAN = 3;
    const TEKNISI_DALAM_PERJALANAN = 4;
    const DALAM_PENGERJAAN_TEKNISI = 5;
    const SELESAI = 6;
    /** Payment Type Order for Warranty */
    const MENUNGGU_KONFIRMASI_GARANSI = 7;
    const PENGAJUAN_GARANSI_DITOLAK = 8;
    // new type order
    const PENDING_ORDER = 9;
    // const SERVICE_DIKERJAKAN = 10;


    /** Payment Order Status */
    const BELUM_BAYAR = 0;
    const BELUM_LUNAS = 1;
    const LUNAS = 2;
    /** Payment Type Order */
    const CASH = "CASH";
    const TRANSFER = "Transfer";
    const TERM_OF_PAYMENT = "Term Of Payment";
    const SUBSCRIPTION= "Subscription";
    const WARRANTY= "Warranty";



    public static function getDescriptionArray(): array
    {
        return [
            self::DIBATALKAN => ['Dibatalkan','badge bg-danger','text-white'],
            self::MENUNGGU_PEMBAYARAN => ['Menunggu Pembayaran','badge bg-warning','text-black'],
            self::PEMBAYARAN_SELESAI => ['Pembayaran Selesai','badge bg-success','text-white'],
            self::TEKNISI_DITUGASKAN => ['Team di Tugaskan','badge bg-warning','text-black'],
            self::TEKNISI_DALAM_PERJALANAN => ['Team Dalam Perjalanan','badge bg-warning','text-black'],
            self::DALAM_PENGERJAAN_TEKNISI => ['Team Dalam Pengerjaan','badge bg-warning','text-black'],
            self::SELESAI => ['Selesai','badge bg-success','text-white'],
            self::MENUNGGU_KONFIRMASI_GARANSI => ['Menunggu Konfirmasi Garansi','badge bg-warning','text-black'],
            self::PENGAJUAN_GARANSI_DITOLAK => ['Pengajuan Garansi Ditolak','badge bg-danger','text-white'],
            self::PENGAJUAN_GARANSI_DITOLAK => ['Pengajuan Garansi Ditolak','badge bg-danger','text-white'],
            self::PENDING_ORDER => ['Pending Order','badge bg-warning','text-black'],
            // self::SERVICE_DIKERJAKAN => ['Service dalam pengerjaan','badge bg-warning','text-black'],
        ];
    }

    public static function getShortFilterArray(): array{
        return [
            self::DIBATALKAN => 'Dibatalkan',
            self::MENUNGGU_PEMBAYARAN => 'Menunggu Bayar',
            self::TEKNISI_DITUGASKAN => 'Dalam Pengerjaan',
            self::SELESAI => 'Selesai',
        ];
    }

    public static function getStatus(): array
    {
        return [
            self::DIBATALKAN => 'Dibatalkan',
            self::MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::PEMBAYARAN_SELESAI => 'Pembayaran Selesai',
            self::TEKNISI_DITUGASKAN => 'Team di Tugaskan',
            self::TEKNISI_DALAM_PERJALANAN => 'Team Dalam Perjalanan',
            self::DALAM_PENGERJAAN_TEKNISI => 'Team Dalam Pengerjaan',
            self::SELESAI => 'Selesai',
            self::MENUNGGU_KONFIRMASI_GARANSI => 'Menunggu Konfirmasi Garansi',
            self::PENGAJUAN_GARANSI_DITOLAK => 'Pengajuan Garansi Ditolak',
        ];
    }
    public static function getPaymentDescriptionArray(): array
    {
        return [
            self::BELUM_BAYAR => ['Belum Bayar','badge bg-danger'],
            self::BELUM_LUNAS => ['Belum Lunas','badge bg-warning'],
            self::LUNAS => ['Lunas','badge bg-success'],
        ];
    }
    public static function getPaymentStatus(): array
    {
        return [
            self::BELUM_BAYAR => 'Belum Bayar',
            self::BELUM_LUNAS => 'Belum Lunas',
            self::LUNAS => 'Lunas',
        ];
    }

    public static function getDataTypePayment(): array
    {
        return [
            self::CASH => 'Cash',
            self::TRANSFER => 'Transfer',
            self::TERM_OF_PAYMENT => 'Term Of Payment',
            self::SUBSCRIPTION => 'Subscription',
            self::WARRANTY => 'Warranty',
        ];
    }
}
