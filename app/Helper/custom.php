<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('check_internet')) {

    function check_internet()
    {
        try {
            $host_name  = 'www.google.com';
            $port_no    = '80';

            $st = (bool)@fsockopen($host_name, $port_no, $err_no, $err_str, 10);
            if (!$st)
                throw new Exception("Please check Your Internet!", 403);

            return [
                'success'    => true,
                'msg'         => 'OK',
                'code'        => 200
            ];
        } catch (Exception $e) {
            return [
                'success'    => false,
                'msg'         => $e->getMessage(),
                'code'        => $e->getCode()
            ];
        }
    }
}
