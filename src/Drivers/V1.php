<?php

namespace Wasi\SDK\Drivers;

class V1 implements Driver
{
    private $id_company;
    private $wasi_token;

    function __construct(array $params = [])
    {
        if(!isset($params['id_company'])) {
            throw new \Exception("id_company is required");
        }
        if(!isset($params['wasi_token'])) {
            throw new \Exception("wasi_token is required");
        }
        $this->setIdCompany($params['id_company']);
    }

    public function setIdCompany(int $id_company)
    {
        $this->id_company = $id_company;
    }

    public function getIdCompany() : int
    {
        return $this->id_company;
    }
}