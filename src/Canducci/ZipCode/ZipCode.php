<?php namespace Canducci\ZipCode;

use Illuminate\Cache\CacheManager;

class ZipCode implements ZipCodeContracts
{

    /**
     * @var $value
     */
    private $value;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->value = '';
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param $value
     * @return ZipCode
     * @throws ZipCodeException
     */
    public function find($value)
    {
        if (mb_strlen($value) === 8 || mb_strlen($value) === 9) {
            $this->value = $value;
            return $this;
        }
        throw new ZipCodeException("Invalid Zip");
    }

    /**
     * @return JSON Javascript
     * @throws ZipCodeException
     */
    public function toJson()
    {
        if ($this->cacheManager->has('cep_'.$this->value))
        {
            $getCache = $this->cacheManager->get('cep_'.$this->value);
            if (is_array($getCache))
            {
                $getCache = json_encode($getCache, JSON_PRETTY_PRINT);
            }
            return $getCache;
        }
        else
        {
            $url = 'http://viacep.com.br/ws/[cep]/json/';
            $url = str_replace('[cep]', $this->value, $url);
            $error = null;
            try
            {
                $get   = file_get_contents($url);
                $error = json_decode($get);
                if (isset($error->erro) && $error->erro === true) {
                    return null;
                }
                $this->cacheManager->forever('cep_'.$this->value, json_decode($get, true));
                return $get;
            } catch (ZipCodeException $e) {
                throw new ZipCodeException("Number and http are invalid");
            }
        }
    }

    /**
     * @return Array
     * @throws ZipCodeException
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return stdClass
     * @throws ZipCodeException
     */
    public function toObject()
    {
        $class = new \stdClass;
        $array = $this->toArray();
        if (!is_null($array) && is_array($array)) {
            $class->cep        = $array['cep'];
            $class->logradouro = $array['logradouro'];
            $class->bairro     = $array['bairro'];
            $class->localidade = $array['localidade'];
            $class->uf         = $array['uf'];
            $class->ibge       = $array['ibge'];
            return $class;
        }
        return null;
    }

}



