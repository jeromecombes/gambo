<?php

namespace Tests\Unit;

use App\Http\Traits\CryptTrait;
use Illuminate\Container\Container;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;

class CryptTraitTest extends TestCase
{
    private object $model;

    protected function setUp(): void
    {
        parent::setUp();

        $key = 'base64:' . base64_encode(random_bytes(32));
        $container = new Container();
        Facade::setFacadeApplication($container);
        $container->instance('encrypter', new Encrypter($key));

        putenv('APP_KEY2=testing-legacy-key');

        $this->model = new class {
            use CryptTrait;

            public $id;

            public function cipher($string, $id = true)
            {
                return $this->encrypt($string, $id);
            }

            public function decipher($string, $id = true)
            {
                return $this->decrypt($string, $id);
            }
        };
    }

    private function legacyEncrypt($plaintext, $key)
    {
        $method = 'AES-128-CTR';
        $derivedKey = openssl_digest($key . getenv('APP_KEY2'), 'SHA256', true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

        return openssl_encrypt($plaintext, $method, $derivedKey, 0, $iv) . '::' . bin2hex($iv);
    }

    public function testEncryptReturnsCiphertextWithoutLegacySeparator()
    {
        $crypted = $this->model->cipher('Next semester schedule');

        $this->assertNotFalse($crypted);
        $this->assertNotSame('Next semester schedule', $crypted);
        $this->assertStringNotContainsString('::', $crypted);
    }

    public function testEncryptDecryptRoundTrip()
    {
        $value = 'Next semester schedule';

        $this->assertSame($value, $this->model->decipher($this->model->cipher($value)));
    }

    public function testEncryptIsRandomized()
    {
        $value = 'Next semester schedule';

        $this->assertNotSame(
            $this->model->cipher($value),
            $this->model->cipher($value)
        );
    }

    public function testEncryptReturnsNullForNullValue()
    {
        $this->assertNull($this->model->cipher(null, false));
    }

    public function testDecryptReturnsNullForNullValue()
    {
        $this->assertNull($this->model->decipher(null));
    }

    public function testDecryptReturnsFalseForInvalidValue()
    {
        $this->assertFalse($this->model->decipher('not-a-valid-payload'));
    }

    public function testDecryptLegacyTokenWithExplicitKey()
    {
        $plaintext = 'Next semester schedule';
        $token = $this->legacyEncrypt($plaintext, '42');

        $this->assertSame($plaintext, $this->model->decipher($token, '42'));
    }

    public function testDecryptLegacyTokenWithModelIdKey()
    {
        $plaintext = 'Next semester schedule';
        $this->model->id = 7;
        $token = $this->legacyEncrypt($plaintext, 7);

        $this->assertSame($plaintext, $this->model->decipher($token));
    }

    public function testDecryptLegacyTokenWithNullKey()
    {
        $plaintext = 'Next semester schedule';
        $token = $this->legacyEncrypt($plaintext, null);

        $this->assertSame($plaintext, $this->model->decipher($token, null));
    }

    public function testDecryptLegacyTokenWithWrongKeyDoesNotReturnPlaintext()
    {
        $plaintext = 'Next semester schedule';
        $token = $this->legacyEncrypt($plaintext, '42');

        $this->assertNotSame($plaintext, $this->model->decipher($token, '43'));
    }
}
