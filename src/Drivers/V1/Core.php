<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Drivers\Driver;
use Wasi\SDK\Models\Customer;
use Wasi\SDK\Models\CustomerType;
use Wasi\SDK\Models\Model;
use Wasi\SDK\Models\Portal;
use Wasi\SDK\Models\Property;
use Wasi\SDK\Models\PropertyType;
use Wasi\SDK\Models\User;

class Core implements Driver
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    private $id_company;
    private $wasi_token;

    function __construct(array $params = [])
    {
        if((!isset($params['public_access']) || !$params['public_access'])) {
            if (!isset($params['id_company'])) {
                throw new \Exception("id_company is required");
            }
            if (!isset($params['wasi_token'])) {
                throw new \Exception("wasi_token is required");
            }
            $this->setIdCompany($params['id_company']);
            $this->setWasiToken($params['wasi_token']);
        }
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

    public function url($path = '')
    {
        $base = "https://api.wasi.co/v1/$path?source=sdk";
        if($this->id_company && $this->wasi_token)
            return "$base&id_company={$this->id_company}&wasi_token={$this->wasi_token}";
        return $base;
    }

    public function find(Model $model, string $id)
    {
        switch (get_class($model)) {
            case Property::class:
                $url = 'property/get/';
                break;
            case User::class:
                $url = 'user/get/';
                break;
            case Customer::class:
                $url = 'client/get/';
                break;
            default:
                $url = '';
                break;
        }
        $url = self::url($url.$id);
        $data = $model->getDataArray();
        foreach ($data as $key => $value)
            $url.="&$key=$value";
        $where = $model->getWhereArray();
        foreach ($where as $key => $value)
            $url.="&$key=$value";
        return $this->request($url);
    }

    public function get(Model $model)
    {
        switch (get_class($model)) {
            case Property::class:
                $url = 'property/search';
                break;
            case User::class:
                $url = 'user/all-users';
                break;
            case Customer::class:
                $url = 'client/search';
                break;
            case CustomerType::class:
                $url = 'client-type/all';
                break;
            case Portal::class:
                $url = 'portal/all';
                break;
            case PropertyType::class:
                $url = 'property-type/all';
                break;
            default:
                $url = '';
                break;
        }
        $url = self::url($url);
        $url = $model->getSkip() ? $url.'&skip='.$model->getSkip() : $url;
        $url = $model->getTake() ? $url.'&take='.$model->getTake() : $url;
        $data = $model->getDataArray();
        foreach ($data as $key => $value)
            $url.="&$key=$value";
        $where = $model->getWhereArray();
        foreach ($where as $key => $value)
            $url.="&$key=$value";
        return $this->request($url);
    }

    public function request($url)
    {
        $json = file_get_contents($url);
        $return = json_decode($json);
        if($return->status == Core::STATUS_ERROR) {
            throw new \Exception($return->message);
        }
        return $return;
    }
}