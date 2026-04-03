<?php

namespace IMO\Core\Security;

use Exception;

/**
 * Encrypter - HIPAA Grade Security
 * Utiliza algoritmos configurables por entorno para cifrado at-rest.
 */
class Encrypter
{
    /**
     * Encripta un valor sensible.
     */
    public static function encrypt(string $value): string
    {
        $key    = config('database.encryption.key');
        $cipher = config('database.encryption.method', 'aes-256-gcm');
        
        if (empty($key) || strlen($key) < 32) {
            throw new Exception("Seguridad Crítica: APP_SECRET debe ser de al menos 32 caracteres.");
        }

        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $tag = ""; 

        $ciphertext = openssl_encrypt(
            $value,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return base64_encode($iv . $tag . $ciphertext);
    }

    /**
     * Desencripta un valor cifrado.
     */
    public static function decrypt(string $payload): string
    {
        $key    = config('database.encryption.key');
        $cipher = config('database.encryption.method', 'aes-256-gcm');
        $decoded = base64_decode($payload);
        
        $ivLength = openssl_cipher_iv_length($cipher);
        $tagLength = 16; 

        if (strlen($decoded) < ($ivLength + $tagLength)) {
            throw new Exception("Payload inválido para decriptación.");
        }

        $iv = substr($decoded, 0, $ivLength);
        $tag = substr($decoded, $ivLength, $tagLength);
        $ciphertext = substr($decoded, $ivLength + $tagLength);

        $decrypted = openssl_decrypt(
            $ciphertext,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($decrypted === false) {
            throw new Exception("Falla de Decriptación (HIPAA Violation Risk).");
        }

        return $decrypted;
    }
}
