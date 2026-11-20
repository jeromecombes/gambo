<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

trait CryptTrait
{
    protected function encrypt($string, $id = true)
    {
        if ($string === null) {
            return null;
        }

        return Crypt::encryptString($string);
    }

    protected function decrypt($crypted_token, $id = true)
    {
        if ($crypted_token === null) {
            return null;
        }

        try {
            return Crypt::decryptString($crypted_token);
        } catch (DecryptException $e) {
            return $this->legacyDecrypt($crypted_token, $id);
        }
    }

    private function legacyDecrypt($crypted_token, $id = true)
    {
        if ($id === true) {
            $key = $this->id ?? null;
        } elseif (is_numeric($id)) {
            $key = $id;
        } else {
            $key = null;
        }

        $decrypted_token = false;

        if (preg_match("/^(.*)::(.*)$/", $crypted_token, $regs)) {
            list(, $crypted_token, $enc_iv) = $regs;
            $enc_method = 'AES-128-CTR';
            $enc_key = openssl_digest($key.getenv('APP_KEY2'), 'SHA256', TRUE);
            $decrypted_token = openssl_decrypt($crypted_token, $enc_method, $enc_key, 0, hex2bin($enc_iv));
            unset($crypted_token, $enc_method, $enc_key, $enc_iv, $regs);
        }

        return $decrypted_token;
    }
}
