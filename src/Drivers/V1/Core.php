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
    const URL_GET = 'Get';
    const URL_FIND = 'Find';
    const URL_SPECIAL =  'Special';

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

    public function __call($name, $arguments)
    {
        $model = $arguments[0];
        $class = get_class($model);
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        return call_user_func_array($interfaceClassName."::".$name, $arguments);
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

    public static function getSubClass(Model $model)
    {
        $class = get_class($model);
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        return self::getClass($interfaceClassName);
    }

    public function url(Model $model, $path = '', $urlType = self::URL_GET)
    {
        $subClass = self::getSubClass($model);
        switch ($urlType) {
            case self::URL_FIND:
                $prePath = $subClass::urlFind($model);
                break;
            case self::URL_GET:
                $prePath = $subClass::urlGet($model);
                break;
            default:
                $prePath = $path;
                $path = '';
                break;
        }
        if($prePath == null)
            throw new \Exception("$urlType method does not supported by {} class");
        $url = "https://api.wasi.co/v1/$prePath$path?source=sdk";
        if($this->id_company && $this->wasi_token)
            $url = "$url&id_company={$this->id_company}&wasi_token={$this->wasi_token}";
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

        return $url;
    }

    #TODO remove
    public function generateRequest(Model $model, string $urlType, array $params)
    {
        $path = $params['path'] ??  '';
        $class = $params['class'] ?? $class = get_class($model);
        $unique = $params['unique'] ?? false;
        $url = self::url($model, $path, $urlType);
        $request = static::request($url);
        if($unique)
            return new $class($request);
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

    public function specialMethod(Model $model, string $url, $class)
    {
        $url = self::url($model, $url, self::URL_SPECIAL);
        $request = static::request($url);
        $elements = [];
        foreach ($request as $key => $value)
            if(is_numeric($key))
                $elements[] = new $class($value);
        $total = isset($request['total']) ? (int) $request['total'] : count($elements);
        if($total > 0)
            return [
                'total' => $total,
                'elements' => $elements,
            ];
        return new $class($request);
    }

    public function find(Model $model, string $id)
    {
        $class = get_class($model);
        $url = self::url($model, $id, self::URL_FIND);
        $request = static::request($url);
        return new $class($request);
    }

    public function preGet(Model $model)
    {
        $class = get_class($model);
        $url = self::url($model, '', self::URL_GET);
        $request = static::request($url);
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

    public static function request($url)
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