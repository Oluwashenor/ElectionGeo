<?php


namespace App\Services;

class AEService
{

    function encrypt($data)
    {
        $key = "encryptionkey123";
        $iv = openssl_random_pseudo_bytes(16); // Generate a random initialization vector (IV)
        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedData);
    }

    function decrypt($encryptedData)
    {
        $key = "encryptionkey123";
        $ivAndEncryptedData = base64_decode($encryptedData);
        $iv = substr($ivAndEncryptedData, 0, 16);
        $encryptedData = substr($ivAndEncryptedData, 16);
        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedData;
    }

    public function Encrypter($dataToEncrypt)
    {
        echo "I got " . $dataToEncrypt;
        $data = $dataToEncrypt;
        $key = "encryptionkey123"; // The encryption key (16, 24, or 32 bytes)
        $iv = openssl_random_pseudo_bytes(16); // Generate a random initialization vector (IV)

        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encryptedDataWithIV = base64_encode($iv . $encryptedData);
        echo "I produced " . $encryptedDataWithIV;
        return $encryptedDataWithIV;
    }

    public function Decrypter($encryptedData)
    {
        echo "I got " . $encryptedData;
        $encryptedDataWithIV = $encryptedData; // The encrypted data with IV
        $key = "encryptionkey123"; // The same encryption key used for encryption

        $decodedData = base64_decode($encryptedDataWithIV);
        $iv = substr($decodedData, 0, 16);
        $encryptedData = substr($decodedData, 16);

        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        echo "I produced " . $decryptedData;
        return $decryptedData;
    }

    public function loggerMan()
    {
        echo "Adesina";
    }
}
