<?php

class CryptHelper
{
    static $instance = null;

    protected $algorimth = null;

    static public function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        if ($this->algorimth === null) {
            $this->algorimth = new Crypt_AES();
        }
    }

    public function setKey($key)
    {
        $this->algorimth->key = $key;

        return $this;
    }

    public function encrypt($plaintext)
    {
        return utf8_encode($this->algorimth->encrypt($plaintext));
    }

    public function decrypt($cipher)
    {
        return $this->algorimth->decrypt(utf8_decode($cipher));
    }

}
