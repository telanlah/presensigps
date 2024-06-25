<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    // Penambahan data absensi di tabel presensi
    public function create()
    {
        $hariIni = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        //validasi row table presensi dimana jika tgl_presensi = tgl hari ini dan presensi.nik = app.nik sudah memiliki row apa belum
        $check = DB::table('presensi')->where('tgl_presensi', $hariIni)->where('nik', $nik)->count();
        return view('presensi.create', compact('check'));
    }
    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        // #dirumah
        // $latitudeKantor = 2.993583;
        // $longitudeKantor = 99.625632;

        // #dikantor
        // $latitudeKantor = "2.9880866";
        // $longitudeKantor = "99.6228656";


        $lokasi = $request->lokasi;
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        // #dimanapun berada
        $latitudeKantor = $lokasiUser[0];
        $longitudeKantor = $lokasiUser[1];


        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        // menghitung radius jarak antara kantor
        $radius  = round($jarak['meters']);

        // echo $radius;
        // echo $latitudeUser;
        // echo $latitudeKantor;
        // dd($radius);

        $image = $request->image;
        // folder tempat penyimpanan foto
        $folderPath = "public/uploads/absensi/";

        //check data tanggal perhari ini
        $check = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        // nama foto
        if ($check > 0) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }

        // $formatName = $nik . "-" . $tgl_presensi[0] . $tgl_presensi[1] . $tgl_presensi[2] . "-".$jamArray[0].$jamArray[1].$jamArray[2];
        $formatName = $nik . "-" . date("Ymd") . "-" . $ket;
        // pemisahan code gambar
        $image_parts = explode(";base64", $image);
        // penyatuan hasil gambar
        $image_base_64 = base64_decode($image_parts[1]);
        // membuat format gambar
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        // validasi jarak antara user dengan kantor user
        if ($radius > 10) {
            echo "Error|Maaf, Anda berada di luar radius Kantor. Anda berjarak " . $radius . " meter dengan Kantor|radius";
        } else {

            $check = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

            // validasi jika user sudah melakukan absen masuk
            if ($check > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'location_out' => $lokasi,
                ];

                // melakukan update ke row yang sudah berisi absen masuk
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    echo 'Success|Terima kasih, Hati-hati di jalan!|out';
                    // jika sukses file gambar akan di simpan di $file dan dengan format yang sudah di decode dari base 64
                    Storage::put($file, $image_base_64);
                } else {
                    echo "Error|Maaf gagal Absen, Hubungi team IT|out";
                }
            } else {
                $data_masuk = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'location_in' => $lokasi,
                ];
                // melakukan insert data baru absen masuk
                $simpan = DB::table('presensi')->insert($data_masuk);
                if ($simpan) {
                    echo 'Success|Terima kasih, Selamat Bekerja!|in';
                    // jika sukses file gambar akan di simpan di $file dan dengan format yang sudah di decode dari base 64
                    Storage::put($file, $image_base_64);
                } else {
                    echo "Error|Maaf gagal Absen, Hubungi team IT|in";
                }
            }
        }
    }

    ///Menghitung jarak koordinat
    function distance($lat1, $long1, $lat2, $long2)
    {
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
