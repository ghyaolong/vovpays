<?php

namespace App\Services;

class AesService
{
    protected $key;


    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    /**
     * 加密
     * @param string $data
     * @return string
     */
    public function encrypt( string $data) {
        return base64_encode(openssl_encrypt($data, 'aes-128-ecb', $this->key, OPENSSL_PKCS1_PADDING));//OPENSSL_PKCS1_PADDING 不知道为什么可以与PKCS5通用,未深究
    }

    /**
     * 解密
     * @param string $data
     * @return string
     */
    public function decrypt( string $data) {
        return openssl_decrypt(base64_decode($data), 'aes-128-ecb', $this->key, OPENSSL_PKCS1_PADDING);//OPENSSL_PKCS1_PADDING 不知道为什么可以与PKCS5通用,未深究
    }

}