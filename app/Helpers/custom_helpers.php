<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/* angka menjadi format Rupiah */
if (! function_exists('numberToRupiah')) {
    
    function numberToRupiah(int|float $number): string
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }
}

/* string Rupiah menjadi angka (integer) */
if (! function_exists('rupiahToNumber')) {
    
    function rupiahToNumber(string $rupiah): int
    {
        // Hapus karakter non-numeric (Rp, titik, spasi, dsb)
        $clean = preg_replace('/[^0-9]/', '', $rupiah);
        return (int) $clean;
    }
}

/* string acak (default panjang 16) */
if (! function_exists('generateRandomString')) {
    
    function generateRandomString(int $length = 16): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}

/* token acak */
if (! function_exists('get_token')) {

    function get_token(int $length = 32): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}

if (! function_exists('send_msg_telegram')) {
    /**
     * Mengirim pesan ke Telegram Bot API.
     * 
     * @param string $message Pesan yang akan dikirim.
     * @param string|null $chat_id ID chat tujuan (bisa ambil dari .env)
     * @return bool True jika sukses, False jika gagal.
     */
    function send_msg_telegram(string $message, ?string $chat_id = null): bool
    {
        try {
            $bot_token = env('TELEGRAM_BOT_TOKEN');
            $chat_id = $chat_id ?? env('TELEGRAM_CHAT_ID');

            if (! $bot_token || ! $chat_id) {
                return false; // konfigurasi tidak lengkap
            }

            $response = Http::post("https://api.telegram.org/bot{$bot_token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message,
            ]);

            return $response->successful();
        } catch (\Throwable $th) {
            return false;
        }
    }
}


/* saya tes menggunakan php artisan tinker */