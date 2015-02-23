<?php namespace Canducci\ZipCode;

interface ZipCodeContracts
{
    /**
     * @param $value
     * @return ZipCode
     * @throws ZipCodeException
     */
    public function find($value);

    /**
     * @return JSON Javascript
     * @throws ZipCodeException
     */
    public function toJson();

    /**
     * @return Array
     * @throws ZipCodeException
     */
    public function toArray();

    /**
     * @return stdClass
     * @throws ZipCodeException
     */
   public function toObject();

}
