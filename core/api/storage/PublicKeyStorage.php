<?php

declare(strict_types=1);

namespace core\api\storage;

use OAuth2\Storage\PublicKeyInterface;

class PublicKeyStorage implements PublicKeyInterface
{
    private $publicKey;
    private $privateKey;
    public $publicKeyFileName = 'jwtRS256.key.pub';
    public $privateKeyFileName = 'jwtRS256.key';

    public function __construct()
    {
        $this->privateKey =  file_get_contents($this->privateKeyFileName, true);
        $this->publicKey =  file_get_contents($this->publicKeyFileName, true);
    }

    public function getPublicKey($client_id = null){
        return  $this->publicKey;
    }

    public function getPrivateKey($client_id = null){
        return  $this->privateKey;
    }

    public function getEncryptionAlgorithm($client_id = null){
        return 'RS256';
    }
}
