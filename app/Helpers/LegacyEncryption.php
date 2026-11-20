<?php

namespace App\Helpers;

class LegacyEncryption
{
    /**
     * Decrypt a value encrypted by the legacy AES-128-CTR scheme
     * (ciphertext followed by "::" and the hex-encoded IV).
     *
     * @param  string|null $crypted_token
     * @param  mixed $key
     * @return string|false|null
     */
    public static function decrypt($crypted_token, $key = null)
    {
        if ($crypted_token === null) {
            return null;
        }

        $decrypted_token = false;

        if (preg_match("/^(.+)::([0-9a-f]+)$/", $crypted_token, $regs)) {
            $enc_method = 'AES-128-CTR';
            $enc_key = openssl_digest($key . getenv('APP_KEY2'), 'SHA256', TRUE);
            $decrypted_token = openssl_decrypt($regs[1], $enc_method, $enc_key, 0, hex2bin($regs[2]));
        }

        return $decrypted_token;
    }
}
