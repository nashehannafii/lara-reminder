<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarNomor;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function sendHaloToAll($code)
    {
        $verifCode = env('SEND_WA_CODE', 'Bismill$h');

        // Verifikasi kode sebelum melanjutkan
        if ($code != $verifCode) {
            return response()->json(['message' => 'Hmm...'], 403);
        }

        $nomors = DaftarNomor::all();
        $url_send_wa = env('SEND_WA_URL', 'http://localhost:3000/send-message');

        foreach ($nomors as $nomor) {
            try {
                $response = Http::post($url_send_wa, [
                    'phoneNumber' => $nomor->nohp,
                    'message' => "Halo"
                ]);

                if (!$response->successful()) {
                    return response()->json([
                        'message' => 'Gagal mengirim pesan ke ' . $nomor->nohp,
                        'error' => $response->body()
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mengirim pesan ke ' . $nomor->nohp,
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['message' => 'Pesan berhasil dikirim ke semua nomor.']);
    }

    public function sendPagi($code)
    {
        $verifCode = env('SEND_WA_CODE', 'Bismill$h');

        // Verifikasi kode sebelum melanjutkan
        if ($code != $verifCode) {
            return response()->json(['message' => 'Hmm...'], 403);
        }

        $nomors = DaftarNomor::all();
        $url_send_wa = env('SEND_WA_URL', 'http://localhost:3000/send-message');

        $message = "
Reminder Kehadiran

Pastikan anda sudah login
https://central.unida.gontor.ac.id/site/login

Cek Kehadiran
https://ekhidmah.unida.gontor.ac.id/kehadiran/index



MyRemind
https://myreminder.foxecho.id/
";
        foreach ($nomors as $nomor) {
            try {
                $response = Http::post($url_send_wa, [
                    'phoneNumber' => $nomor->nohp,
                    'message' => $message
                ]);

                if (!$response->successful()) {
                    return response()->json([
                        'message' => 'Gagal mengirim pesan ke ' . $nomor->nohp,
                        'error' => $response->body()
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mengirim pesan ke ' . $nomor->nohp,
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['message' => 'Pesan berhasil dikirim ke semua nomor.']);
    }

    public function sendSore($code)
    {
        $verifCode = env('SEND_WA_CODE', 'Bismill$h');

        // Verifikasi kode sebelum melanjutkan
        if ($code != $verifCode) {
            return response()->json(['message' => 'Hmm...'], 403);
        }

        $nomors = DaftarNomor::all();
        $url_send_wa = env('SEND_WA_URL', 'http://localhost:3000/send-message');

        $message = "
Reminder Kepulangan

Formulir laporan kinerja harian berikut: 
https://forms.gle/qxNc1vQs2rZsm8dT8

Pastikan anda sudah login
https://central.unida.gontor.ac.id/site/login

Cek Kepulangan
https://ekhidmah.unida.gontor.ac.id/kehadiran/index



MyRemind
https://myreminder.foxecho.id/
        ";
        foreach ($nomors as $nomor) {
            try {
                $response = Http::post($url_send_wa, [
                    'phoneNumber' => $nomor->nohp,
                    'message' => $message
                ]);

                if (!$response->successful()) {
                    return response()->json([
                        'message' => 'Gagal mengirim pesan ke ' . $nomor->nohp,
                        'error' => $response->body()
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mengirim pesan ke ' . $nomor->nohp,
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['message' => 'Pesan berhasil dikirim ke semua nomor.']);
    }
}
