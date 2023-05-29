<?php


namespace App\Services;

class AEService
{
    public function Encrypter()
    {
        $data = "This is the data to be encrypted";
        $key = "encryptionkey123"; // The encryption key (16, 24, or 32 bytes)
        $iv = openssl_random_pseudo_bytes(16); // Generate a random initialization vector (IV)

        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encryptedDataWithIV = base64_encode($iv . $encryptedData);

        echo $encryptedDataWithIV;
    }

    public function Decrypter($encryptedData)
    {
        $encryptedDataWithIV = "BASE64_ENCODED_ENCRYPTED_DATA"; // The encrypted data with IV
        $key = "encryptionkey123"; // The same encryption key used for encryption

        $decodedData = base64_decode($encryptedDataWithIV);
        $iv = substr($decodedData, 0, 16);
        $encryptedData = substr($decodedData, 16);

        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        echo $decryptedData;
    }

    public function loggerMan()
    {
        echo "Adesina";
    }
}
