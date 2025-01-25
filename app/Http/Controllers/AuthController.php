<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarNomor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $isRegister = $request->daftarBtn;
        $nohp = $request->nohp;
        if ($isRegister == 1) {
            $validator = Validator::make($request->all(), [
                'nohp' => 'required|string|unique:daftar_nomor,nohp',
            ]);

            if ($validator->fails()) {

                $user = DaftarNomor::where('nohp', $nohp)->first();

                if ($user->status == 1) {
                    return response()->json(['message' => $validator->errors()->first()], 400);
                }
            }
        }
        $url_send_wa = env('SEND_WA_URL', 'http://localhost:3000/send-message');

        $otp = rand(100000, 999999); // Generate OTP  

        // Kirim OTP melalui WhatsApp  
        $response = Http::post($url_send_wa, [
            'phoneNumber' => $nohp,
            'message' => "Your OTP is: $otp"
        ]);

        if ($response->successful()) {
            // Simpan nomor dan OTP ke database
            if ($isRegister == 1) {
                DaftarNomor::create([
                    'nohp' => $nohp,
                    'otp' => $otp
                ]);
            } else {
                $user = DaftarNomor::where('nohp', $nohp)->first();
                $user->otp = $otp;
                $user->save();
            }

            return response()->json(['message' => 'OTP sent successfully!']);
        } else {
            return response()->json(['message' => 'Failed to send OTP. Please try again.'], 500);
        }
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nohp' => 'required|string',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $url_send_wa = env('SEND_WA_URL', 'http://localhost:3000/send-message');
        $nohp = $request->nohp;
        $otp = $request->otp;

        $user = DaftarNomor::where('nohp', $nohp)->first();

        if ($user && $user->otp == $otp) {

            if ($user->status == true) {
                $user->delete();

                $response = Http::post($url_send_wa, [
                    'phoneNumber' => $request->nohp,
                    'message' => "Nomor Anda sudah tidak berlangganan!"
                ]);

                return response()->json(['message' => 'OTP verified successfully!']);
            }
            $user->status = true;
            $user->save();
            $response = Http::post($url_send_wa, [
                'phoneNumber' => $request->nohp,
                'message' => "Nomor Anda berhasil diverifikasi!"
            ]);

            return response()->json(['message' => 'OTP verified successfully!']);
        }

        return response()->json(['message' => 'Invalid OTP!'], 400);
    }
}
