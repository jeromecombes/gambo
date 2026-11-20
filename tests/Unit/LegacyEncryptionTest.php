<?php

namespace Tests\Unit;

use App\Helpers\LegacyEncryption;
use PHPUnit\Framework\TestCase;

class LegacyEncryptionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        putenv('APP_KEY2=testing-legacy-key');
    }

    private function legacyEncrypt($plaintext, $key)
    {
        $method = 'AES-128-CTR';
        $derivedKey = openssl_digest($key . getenv('APP_KEY2'), 'SHA256', true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

        return openssl_encrypt($plaintext, $method, $derivedKey, 0, $iv) . '::' . bin2hex($iv);
    }

    public function testDecryptRoundTripWithNullKey()
    {
        $plaintext = 'Next semester schedule';
        $token = $this->legacyEncrypt($plaintext, null);

        $this->assertSame($plaintext, LegacyEncryption::decrypt($token, null));
    }

    public function testDecryptRoundTripWithNumericKey()
    {
        $plaintext = 'Spring 2027';
        $token = $this->legacyEncrypt($plaintext, '42');

        $this->assertSame($plaintext, LegacyEncryption::decrypt($token, '42'));
    }

    public function testDecryptRoundTripWithEmptyKey()
    {
        $plaintext = 'Spring 2027';
        $token = $this->legacyEncrypt($plaintext, '');

        $this->assertSame($plaintext, LegacyEncryption::decrypt($token, ''));
    }

    public function testDecryptReturnsNullForNullValue()
    {
        $this->assertNull(LegacyEncryption::decrypt(null));
    }

    public function testDecryptReturnsFalseForValueWithoutSeparator()
    {
        $this->assertFalse(LegacyEncryption::decrypt('plaintext-value'));
    }

    public function testDecryptAcceptsIntegerKey()
    {
        $plaintext = 'Next semester schedule';
        $token = $this->legacyEncrypt($plaintext, '42');

        $this->assertSame($plaintext, LegacyEncryption::decrypt($token, 42));
    }

    public function testDecryptValueContainingSeparator()
    {
        $plaintext = 'Course::advanced';
        $token = $this->legacyEncrypt($plaintext, null);

        $this->assertSame($plaintext, LegacyEncryption::decrypt($token, null));
    }
}
