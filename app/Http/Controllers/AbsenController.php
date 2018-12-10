<?php

namespace App\Http\Controllers;

use App\absen;
use Illuminate\Http\Request;
use Carbon\carbon;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
      // dd(Carbon::now()->toTimeString());
        $data = absen::all();
        if($request->cari){
          $data = absen::where('nama',$request->cari);
        }
        return response()->json(['status' => 'success', 'data' => absen::all()]);
    }

    public function store(Request $request)
    {
        $pesan = null;
        $waktu = Carbon::now()->toTimeString();

        $request->validate([
          'nama' => 'required',
        ]);

        $hasil = absen::where('nama',$request->nama)->whereRaw('day(waktupagi) = '.Carbon::now()->day.'')->first();
        if(is_null($hasil)){
          $absen = new absen;
          $absen->nama = $request->nama;
            if($waktu>='08:00:09' && $waktu<='11:00:09'){
              $request->validate([
                'pagi' => 'required',
              ]);
              $absen->pagi = $request->pagi;
              $absen->waktupagi = now();
              $pesan = 'Berhasil Melakukan Absen Pagi';
            }else if($waktu>='11:00:10' && $waktu<='14:00:09'){
              $request->validate([
                'siang' => 'required',
              ]);
              $absen->siang = $request->siang;
              $absen->waktusiang = now();
              $pesan = 'Berhasil Melakukan Absen Siang';
            }else if($waktu>='14:00:10' && $waktu<='23:55:09'){
              $request->validate([
                'sore' => 'required',
              ]);
              $absen->sore = $request->sore;
              $absen->waktusore =now();
              $pesan = 'Berhasil Melakukan Absen Sore';
            }else{

            }

          if($absen->save()){
            return response()->json(['status' => 'success', 'message' => $pesan ],201);
          }else{
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error' ],500);
          }
        }else{
          $absen = absen::find($hasil->id);
          if($waktu>='11:00:09' && $waktu<='14:00:09'){
            $request->validate([
              'siang' => 'required',
            ]);
            $absen->siang = $request->siang;
            $absen->waktusiang = now();
            $pesan = 'Berhasil Melakukan Absen Siang';
          }else if($waktu>='14:00:10' && $waktu<='23:55:09'){
            $request->validate([
              'sore' => 'required',
            ]);

            $absen->sore = $request->sore;
            $absen->waktusore =now();
            $pesan = 'Berhasil Melakukan Absen Sore';
          }

          if($absen->save()){
            return response()->json(['status' => 'success', 'message' => $pesan ],201);
          }else{
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error' ],500);
          }
        }

    }

    public function show(absen $absen)
    {
      // dd($absen);
        return response()->json(['status' => 'success', 'data' => $absen]);
    }


    public function destroy(absen $absen)
    {
        if(absen->delete()){
          return response()->json(['status' => 'success', 'message' => 'berhasil Menghapus data' ],201);
        }
    }
}
