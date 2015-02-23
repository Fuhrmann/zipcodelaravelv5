<?php namespace {

    if (!function_exists('zipcode'))
    {
        /**
         * @param $value
         * @return ZipCode
         * @throws ZipCodeException
         */
        function zipcode($value)
        {
            $zip_code = app('Canducci\ZipCode\ZipCodeContracts');
            return $zip_code->find($value);
        }

    }

}
