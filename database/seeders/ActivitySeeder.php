<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepairAttachmentItem;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["title" => "FOTO SPK TANPA TANDA TANGAN KONSUMEN", "description" => "FOTO SPK TANPA TANDA TANGAN KONSUMEN", "image_capture_time" => 0],
            ["title" => "FOTO KARTU GARANSI", "description" => "FOTO KARTU GARANSI", "image_capture_time" => 0],
            ["title" => "FOTO FAKTUR PEMBELIAN", "description" => "FOTO FAKTUR PEMBELIAN", "image_capture_time" => 0],
            ["title" => "FOTO TANGGAL PRODUKSI", "description" => "FOTO TANGGAL PRODUKSI", "image_capture_time" => 0],
            ["title" => "FOTO SUHU HEMBUSAN INDOOR AC", "description" => "FOTO SUHU HEMBUSAN INDOOR AC", "image_capture_time" => 0],
            ["title" => "FOTO KONDISI AWAL AC DI INDOOR", "description" => "FOTO KONDISI AWAL AC DI INDOOR", "image_capture_time" => 0],
            ["title" => "FOTO KONDISI AKHIR AC DI INDOOR", "description" => "FOTO KONDISI AKHIR AC DI INDOOR", "image_capture_time" => 1],
            ["title" => "FOTO KONDISI AWAL AC DI OUTDOOR", "description" => "FOTO KONDISI AWAL AC DI OUTDOOR", "image_capture_time" => 0],
            ["title" => "FOTO KONDISI AKHIR AC DI OUTDOOR", "description" => "FOTO KONDISI AKHIR AC DI OUTDOOR", "image_capture_time" => 1],
            ["title" => "FOTO KONDISI AC SEBELUM DI CUCI INDOOR", "description" => "FOTO KONDISI AC SEBELUM DI CUCI INDOOR", "image_capture_time" => 0],
            ["title" => "FOTO KONDISI AC SESUDAH DI CUCI INDOOR", "description" => "FOTO KONDISI AC SESUDAH DI CUCI INDOOR", "image_capture_time" => 1],
            ["title" => "FOTO KONDISI AC SEBELUM DI CUCI OUTDOOR", "description" => "FOTO KONDISI AC SEBELUM DI CUCI OUTDOOR", "image_capture_time" => 0],
            ["title" => "FOTO KONDISI AC SESUDAH DI CUCI OUTDOOR", "description" => "FOTO KONDISI AC SESUDAH DI CUCI OUTDOOR", "image_capture_time" => 1],
            ["title" => "FOTO VOLTASE SEBELUM", "description" => "FOTO VOLTASE SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO VOLTASE SESUDAH", "description" => "FOTO VOLTASE SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO AMPERE SEBELUM", "description" => "FOTO AMPERE SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO AMPERE SESUDAH", "description" => "FOTO AMPERE SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO TEKANAN FREON SEBELUM", "description" => "FOTO TEKANAN FREON SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO TEKANAN FREON SESUDAH", "description" => "FOTO TEKANAN FREON SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO TITIK KERUSAKAN SPARE PART SEBELUM", "description" => "FOTO TITIK KERUSAKAN SPARE PART SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO TITIK KERUSAKAN SPARE PART SESUDAH", "description" => "FOTO TITIK KERUSAKAN SPARE PART SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO SPARE PART", "description" => "FOTO SPARE PART", "image_capture_time" => 0],
            ["title" => "FOTO SPK TANDA TANGAN KONSUMEN", "description" => "FOTO SPK TANDA TANGAN KONSUMEN", "image_capture_time" => 1],
            ["title" => "FOTO NAMEPLATE OUTDOOR", "description" => "FOTO NAMEPLATE OUTDOOR", "image_capture_time" => 0],
            ["title" => "FOTO KURAS VAKUM SEBELUM", "description" => "FOTO KURAS VAKUM SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO KURAS VAKUM SESUDAH", "description" => "FOTO KURAS VAKUM SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO LAS EVAP SEBELUM", "description" => "FOTO LAS EVAP SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO LAS EVAP SESUDAH", "description" => "FOTO LAS EVAP SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO LAS KONDENSOR SEBELUM", "description" => "FOTO LAS KONDENSOR SEBELUM", "image_capture_time" => 0],
            ["title" => "FOTO LAS KONDENSOR SESUDAH", "description" => "FOTO LAS KONDENSOR SESUDAH", "image_capture_time" => 1],
            ["title" => "FOTO FLARING INDOOR", "description" => "FOTO FLARING INDOOR", "image_capture_time" => 1],
            ["title" => "FOTO FLARING OUTDOOR", "description" => "FOTO FLARING OUTDOOR", "image_capture_time" => 1],
            ["title" => "FOTO FLUSHING INDOOR", "description" => "FOTO FLUSHING INDOOR", "image_capture_time" => 1],
            ["title" => "FOTO FLUSHING OUTDOOR", "description" => "FOTO FLUSHING OUTDOOR", "image_capture_time" => 1],
            ["title" => "FOTO TEST PRESSURE INDOOR", "description" => "FOTO TEST PRESSURE INDOOR", "image_capture_time" => 1],
            ["title" => "FOTO TEST PRESSURE OUTDOOR", "description" => "FOTO TEST PRESSURE OUTDOOR", "image_capture_time" => 1],
        ];

        foreach ($data as $item) {
            RepairAttachmentItem::create($item);
        }
    }
}
