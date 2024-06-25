<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {

        //menampillkan data jam masuk dan pulang
        $hariIni = date('Y-m-d');
        $bulanKini = date('m') * 1;
        $tahunKini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensiHariIni = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariIni)->first();
        // mengambil semua data
        $historyBulanIni = DB::table('presensi')->where('nik', $nik)->whereRaw('MONTH(tgl_presensi)="' . $bulanKini . '"')->whereRaw('YEAR(tgl_presensi)="' . $tahunKini . '"')->orderBy('tgl_presensi')->get();
        // halaman untuk user
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('dashboard.dashboard', compact('presensiHariIni', 'historyBulanIni','namaBulan','bulanKini', 'tahunKini'));
    }
}
