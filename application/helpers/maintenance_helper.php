<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('maintenance_request')) {
    function maintenance_request()
    {
        return false;
    }
}
