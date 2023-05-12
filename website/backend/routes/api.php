<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// LOGIN LOGOUT
Route::post('login', 'Api\LoginController@login');
Route::post('loginAndroid', 'Api\LoginAndroidController@login');
Route::post('logout', 'Api\AuthController@logout');



    Route::get('user/{id}', 'Api\AuthController@show');
    Route::post('logout', 'Api\AuthController@logout');
    Route::put('update', 'Api\AuthController@update');

    //Promo
    Route::get('promo', 'Api\PromoController@index');
    Route::get('promo/{id}', 'Api\PromoController@show');
    Route::post('promo', 'Api\PromoController@store');
    Route::put('promo/{id}', 'Api\PromoController@update');
    Route::delete('promo/{id}', 'Api\PromoController@destroy');

    //Role
    Route::get('role', 'Api\RoleController@index');
    Route::get('role/{id_role}', 'Api\RoleController@show');
    Route::post('role', 'Api\RoleController@store');
    Route::put('role/{id_role}', 'Api\RoleController@update');
    Route::delete('role/{id_role}', 'Api\RoleController@destroy');

    //Pegawai
    Route::get('pegawai', 'Api\PegawaiController@index');
    Route::get('pegawai/{id_pegawai}', 'Api\PegawaiController@show');
    Route::post('pegawai', 'Api\PegawaiController@store');
    Route::put('pegawai/{id_pegawai}', 'Api\PegawaiController@update');
    Route::delete('pegawai/{id_pegawai}', 'Api\PegawaiController@destroy');
    Route::post('fotoPegawai/{id_pegawai}','Api\PegawaiController@updateFoto');

    //Instruktur
    Route::get('instruktur', 'Api\InstrukturController@index');
    Route::get('instruktur/{id_instruktur}', 'Api\InstrukturController@show');
    Route::post('instruktur', 'Api\InstrukturController@store');
    Route::put('instruktur/{id_instruktur}', 'Api\InstrukturController@update');
    Route::delete('instruktur/{id_instruktur}', 'Api\InstrukturController@destroy');

    //Member
    Route::get('member', 'Api\MemberController@index');
    Route::get('member/{id_member}', 'Api\MemberController@show');
    Route::post('member', 'Api\MemberController@store');
    Route::put('member/{id_member}', 'Api\MemberController@update');
    Route::delete('member/{id_member}', 'Api\MemberController@destroy');

    //Jadwal
    Route::get('jadwal', 'Api\JadwalController@index');
    Route::get('jadwal/{id_jadwal}', 'Api\JadwalController@show');
    Route::post('jadwal', 'Api\JadwalController@store');
    Route::put('jadwal/{id_jadwal}', 'Api\JadwalController@update');
    Route::delete('jadwal/{id_jadwal}', 'Api\JadwalController@destroy');

     //JadwalHarian
     Route::get('jadwalHarian', 'Api\JadwalHarianController@index');
     Route::get('jadwalHarian/{id_jadwal_harian}', 'Api\JadwalHarianController@show');
     Route::post('jadwalHarian', 'Api\JadwalHarianController@store');
     Route::put('jadwalHarian/{id_jadwal_harian}', 'Api\JadwalHarianController@update');
     Route::delete('jadwalHarian/{id_jadwal_harian}', 'Api\JadwalHarianController@destroy');

     //AktivasiTahunan
     Route::get('aktivasiTahunan', 'Api\AktivasiTahunanController@index');
     Route::get('aktivasiTahunan/{id_aktivasi_tahunan}', 'Api\AktivasiTahunanController@show');
     Route::post('aktivasiTahunan', 'Api\AktivasiTahunanController@store');
     Route::put('aktivasiTahunan/{id_aktivasi_tahunan}', 'Api\AktivasiTahunanController@update');
     Route::delete('aktivasiTahunan/{id_aktivasi_tahunan}', 'Api\AktivasiTahunanController@destroy');

     //DepositUang
     Route::get('depositUang', 'Api\DepositUangController@index');
     Route::get('depositUang/{id_deposit_uang}', 'Api\DepositUangController@show');
     Route::post('depositUang', 'Api\DepositUangController@store');
     Route::put('depositUang/{id_deposit_uang}', 'Api\DepositUangController@update');
     Route::delete('depositUang/{id_deposit_uang}', 'Api\DepositUangController@destroy');

     //DepositUang
     Route::get('depositKelas', 'Api\DepositKelasController@index');
     Route::get('depositKelas/{id_deposit_kelas}', 'Api\DepositKelasController@show');
     Route::post('depositKelas', 'Api\DepositKelasController@store');
     Route::put('depositKelas/{id_deposit_kelas}', 'Api\DepositKelasController@update');
     Route::delete('depositKelas/{id_deposit_kelas}', 'Api\DepositKelasController@destroy');
 

    
    
    
    