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
            $zip_code = app('Canducci\ZipCode\ZipCode');
            return $zip_code->find($value);
        }

    }

}
