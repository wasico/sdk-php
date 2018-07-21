<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Drivers\Driver;
use Wasi\SDK\Drivers\V1\SubModels\SubModel;
use Wasi\SDK\Models\Banner;
use Wasi\SDK\Models\Country;
use Wasi\SDK\Models\Customer;
use Wasi\SDK\Models\CustomerType;
use Wasi\SDK\Models\Model;
use Wasi\SDK\Models\Portal;
use Wasi\SDK\Models\Property;
use Wasi\SDK\Models\PropertyType;
use Wasi\SDK\Models\Region;
use Wasi\SDK\Models\Service;
use Wasi\SDK\Models\User;

class Core implements Driver
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    private $id_company;
    private $wasi_token;

    private static $subClasses = [];

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
        $class = get_class($model);
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        $subClass = self::getClass($interfaceClassName);
       
        switch ($class) {
            case Property::class:
                $url = 'property/get/';
                break;
            case User::class:
                $url = 'user/get/';
                break;
            case Customer::class:
                $url = 'client/get/';
                break;
            case Service::class:
                $url = 'service/get/';
                break;
            case Region::class:
                $url = 'location/region/';
                break;
            default:
                $url = $subClass::urlFind();
                break;
        }
        $url = self::url($url.$id);
        $data = $model->getDataArray();
        foreach ($data as $key => $value)
            $url.="&$key=$value";
        $where = $model->getWhereArray();
        foreach ($where as $key => $value)
            $url.="&$key=$value";
        $request = $this->request($url);
        return new $class($request);
    }

    public function preGet(Model $model)
    {
        $class = get_class($model);
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        $subClass = self::getClass($interfaceClassName);
        switch ($class) {
            case Property::class:
                $url = 'property/search';
                break;
            case User::class:
                $url = 'user/all-users';
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
            case Service::class:
                $url = 'service/search';
                break;
            default:
                $url = $subClass::urlGet();
                break;
        }
        $url = self::url($url);
        $url = $model->getSkip() ? $url.'&skip='.$model->getSkip() : $url;
        $url = $model->getTake() ? $url.'&take='.$model->getTake() : $url;
        $url = $model->getOrderBy() ? $url.'&order_by='.$model->getOrderBy() : $url;
        $url = $model->getOrder() ? $url.'&order='.$model->getOrder() : $url;
        $data = $model->getDataArray();
        foreach ($data as $key => $value)
            $url.="&$key=$value";
        $where = $model->getWhereArray();
        foreach ($where as $key => $value)
            $url.="&$key=$value";
        $request = $this->request($url);
        $elements = [];
        foreach ($request as $key => $value)
            if(is_numeric($key))
                $elements[] = new $class($value);
        $total = isset($request['total']) ? (int) $request['total'] : count($elements);
        return [
            'total' => $total,
            'elements' => $elements,
        ];
    }

    public function count(Model $model)
    {
        return $this->preGet($model)['total'];
    }

    public function get(Model $model)
    {
        return $this->preGet($model)['elements'];
    }

    public function request($url)
    {
        $json = file_get_contents($url);
        $return = json_decode($json, true);
        if($return['status'] == Core::STATUS_ERROR) {
            throw new \Exception($return['message']);
        }
        return $return;
    }

    public static function getClass(string $class) : SubModel
    {
        if(isset(static::$subClasses[$class]))
            return static::$subClasses[$class];
        return static::$subClasses[$class] = new $class();
    }
}