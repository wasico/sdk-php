<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Drivers\Driver;
use Wasi\SDK\Models\Model;

class Core implements Driver
{
    const STATUS_ERROR = 'error';

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
        $this->setWasiToken($params['wasi_token']);
    }

    public function setIdCompany(int $id_company)
    {
        $this->id_company = $id_company;
    }

    public function getIdCompany() : int
    {
        return $this->id_company;
    }

    public function setWasiToken(string $wasi_token)
    {
        $this->wasi_token = $wasi_token;
    }

    public function getWasiToken() : string
    {
        return $this->wasi_token;
    }

    public static function url($path = '')
    {
        return 'https://api.wasi.co/v1/'.$path;
    }

    public function get(Model $model)
    {
        switch (get_class($model)) {
            case \Wasi\SDK\Models\Property::class:
                $url = self::url('property/search');
                break;
        }
        $where = $model->getWhereArray();
        $first = true;
        foreach ($where as $key => $value)
            if($first){
                $first = false;
                $url.="?$key=$value";
            } else
                $url.="&$key=$value";
        $this->request($url);
    }

    public function request($url)
    {
        $json = file_get_contents($url);
        $return = json_decode($json);
        if($return->status == Core::STATUS_ERROR) {
            throw new \Exception($return->message);
        }
        die(var_dump($return));
    }
}