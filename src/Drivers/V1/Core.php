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
    const URL_UPDATE = 'Update';
    const URL_SPECIAL =  'Special';

    private $id_company;
    private $wasi_token;
    static private $baseURL = 'https://api.wasi.co/v1/';
    static private $baseURLAlternative = null;
    private $globalParams = [];

    public static $coreCache = [];

    public static $totalRequests = 0;

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

        if (isset($params['base_url']))
            $this->setBaseURL($params['base_url']);

        if (isset($params['base_url_alternative']))
            $this->setBaseURLAlternative($params['base_url_alternative']);

        if (isset($params['global_params']))
            $this->globalParams = $params['global_params'];
    }

    public static function getCoreCache($key) {
        if(isset(static::$coreCache[$key]))
            return static::$coreCache[$key];
        return null;
    }

    private function setCoreCache($key, $value) {
        if(count(static::$coreCache)<100)
            static::$coreCache[$key] = $value;
        return $value;
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

    public static function setBaseURL(string $basePath)
    {
        self::$baseURL = $basePath;
    }

    public static function getBaseURL() : string
    {
        return self::$baseURL;
    }

    public static function setBaseURLAlternative(string $basePath)
    {
        self::$baseURLAlternative = $basePath;
    }

    public static function getBaseURLAlternative()
    {
        return self::$baseURLAlternative;
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
            case self::URL_UPDATE:
                $prePath = $subClass::urlUpdate($model);
                break;
            default:
                $prePath = $path;
                $path = '';
                break;
        }
        if($prePath == null)
            throw new \Exception("$urlType method does not supported by ".get_class($model)." class");
        $url = $this->getBaseURL()."$prePath$path?source=sdk";
        $url .= $this->addArrayToURL(null, $this->globalParams);

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
        $url .= $this->addArrayToURL($model, $model->getChangedArray());

        return $url;
    }

    public function addArrayToURL(Model $model = null, array $data) : string
    {
        $standartAttributes = $model ? $model->standartAttributes() : null;
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
        $modelKeyString = $model->getKeyString();
        if($cache = static::getCoreCache($modelKeyString))
            return $cache;
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
            return static::setCoreCache($modelKeyString, new $class($request));

        $elements = [];
        foreach ($request as $key => $value)
            if(is_numeric($key))
                $elements[] = new $class($value);
        if($subClass && $subClass->customTotal)
            $total = $subClass->customTotal($request);
        else
            $total = isset($request['total']) ? (int) $request['total'] : count($elements);
        return static::setCoreCache($modelKeyString, [
            'total' => $total,
            'elements' => $elements,
        ]);
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

    public function update(Model $model) : bool
    {
        $url = self::url($model, $model->{$model->getIdKey()}, self::URL_UPDATE);
        $request = static::request($url);
        return true;
    }

    public static function getTotalRequests() {
        return static::$totalRequests;
    }

    public static function request($url, $attempt = 0)
    {
        //die($url);
        if(@$json = file_get_contents($url)) {
            $return = json_decode($json, true);
            static::$totalRequests++;
            if ($return['status'] == Core::STATUS_ERROR) {
                throw new ApiException($return['message']);
            }
            return $return;
        } else {
            if($attempt < 1) {
                if(self::getBaseURLAlternative())
                    $url = str_replace(self::getBaseURL(), self::getBaseURLAlternative(), $url);
                return self::request($url, ++$attempt);
            }
            throw new \Exception("Could not connect to the API, URL: $url");
        }
    }
}