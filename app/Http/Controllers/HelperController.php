<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function index()
    {
        // Contoh 1: Format angka ke Rupiah
        $rupiah = numberToRupiah(15000);

        // Contoh 2: Ubah string Rupiah ke angka
        $angka = rupiahToNumber('Rp15.000');

        // Contoh 3: Generate random string
        $randomString = generateRandomString(12);

        // Contoh 4: Generate token acak
        $token = get_token(32);

        // Contoh 5: Kirim pesan ke Telegram
        $sent = send_msg_telegram("Test dari Laravel!\nToken: $token");

        // Kembalikan hasil ke browser (atau view)
        return response()->json([
            'rupiah'        => $rupiah,
            'angka'         => $angka,
            'randomString'  => $randomString,
            'token'         => $token,
            'telegram_sent' => $sent ? 'Berhasil dikirim ✅' : 'Gagal dikirim ❌',
        ]);
    }
}