<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Drivers\Driver;
use Wasi\SDK\Drivers\V1\SubModels\SubModel;
use Wasi\SDK\Exceptions\ApiException;
use Wasi\SDK\Models\Model;

class Core implements Driver
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const URL_GET = 'Get';
    const URL_FIND = 'Find';
    const URL_SPECIAL =  'Special';

    private $id_company;
    private $wasi_token;
    private $baseURL = 'https://api.wasi.co/v1/';

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
            if (isset($params['base_url']))
                $this->setBaseURL($params['base_url']);
        }
    }

    public function __call($name, $arguments)
    {
        $model = $arguments[0];
        $class = get_class($model);
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        $subClass = new $interfaceClassName();
        return call_user_func_array([$subClass, $name], $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $class = $arguments[0];
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        return call_user_func_array("$interfaceClassName::".$name, $arguments);
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

    public function setBaseURL(string $basePath)
    {
        $this->baseURL = $basePath;
    }

    public function getBaseURL() : string
    {
        return $this->baseURL;
    }

    public static function getSubClass(Model $model): ? SubModel
    {
        $class = get_class($model);
        if(isset(static::$subClasses[$class]))
            return static::$subClasses[$class];
        $reflect = new \ReflectionClass($class);
        $interfaceClassName = "\\Wasi\\SDK\\Drivers\\V1\\SubModels\\".$reflect->getShortName();
        if(class_exists($interfaceClassName))
            return static::$subClasses[$class] = new $interfaceClassName();
        return null;
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
            throw new \Exception("$urlType method does not supported by ".get_class($model)." class");
        $url = $this->getBaseURL()."$prePath$path?source=sdk";
        if($this->id_company && $this->wasi_token)
            $url = "$url&id_company={$this->id_company}&wasi_token={$this->wasi_token}";
        $url = $model->getSkip() ? $url.'&skip='.$model->getSkip() : $url;
        $url = $model->getTake() ? $url.'&take='.$model->getTake() : $url;
        $url = $model->getOrderBy() ? $url.'&order_by='.$model->getOrderBy() : $url;
        $url = $model->getOrder() ? $url.'&order='.$model->getOrder() : $url;

        if(!count($model->getDataArray()) && $subClass && $subClass->autoData)
            $url .= $this->addArrayToURL($model, $subClass::autoData());
        $url .= $this->addArrayToURL($model, $model->getDataArray());
        $url .= $this->addArrayToURL($model, $model->getWhereArray());

        return $url;
    }

    public function addArrayToURL(Model $model, array $data) : string
    {
        $standartAttributes = $model->standartAttributes();
        $url = '';
        foreach ($data as $key => $value) {
            if(isset($standartAttributes[$key])) {
                switch ($standartAttributes[$key]->getType()) {
                    case Attribute::BOOLEAN:
                        $url .= "&$key=".($value==true?'true':'false');
                        break;
                    default:
                        $url .= "&$key=".urlencode($value);
                        break;
                }
            } else {
                if(is_bool($value))
                    $url .= "&$key=".($value==true?'true':'false');
                else
                    $url .= "&$key=" . urlencode($value);
            }
        }
        return $url;
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
        $subClass = self::getSubClass($model);
        $objectGet = false;

        if($class == WrappedModel::class) {
            $objectGet = $model->isObjectGet();
            $class = $model->getWrappedModel();
            $url = self::url($model, $model->getPath(), self::URL_SPECIAL);
        } else
            $url = self::url($model, '', self::URL_GET);
        $request = static::request($url);

        if($objectGet)
            return new $class($request);

        $elements = [];
        foreach ($request as $key => $value)
            if(is_numeric($key))
                $elements[] = new $class($value);
        if($subClass && $subClass->customTotal)
            $total = $subClass->customTotal($request);
        else
            $total = isset($request['total']) ? (int) $request['total'] : count($elements);
        return [
            'total' => $total,
            'elements' => $elements,
        ];
    }

    public function count(Model $model)
    {
        $return = $this->preGet($model);
        return is_array($return) && isset($return['total']) ? $return['total'] : $return;
    }

    public function get(Model $model)
    {
        $subClass = self::getSubClass($model);
        if($subClass && $subClass->customGet)
            $return = $subClass->customGet($model);
        else
            $return = $this->preGet($model);
        return is_array($return) && isset($return['elements']) ? $return['elements'] : $return;
    }

    public static function request($url)
    {
        $json = file_get_contents($url);
        $return = json_decode($json, true);
        if($return['status'] == Core::STATUS_ERROR) {
            throw new ApiException($return['message']);
        }
        return $return;
    }
}