<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('curl_request')) {
    function curl_request($url, $method = 'GET', $data = array(), $headers = array()) {
        $ci =& get_instance();

        $ch = curl_init();

        // Set cURL options
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER         => FALSE,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_ENCODING       => '',
            CURLOPT_AUTOREFERER    => TRUE,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
        );

        // Set cURL method
        if ($method === 'POST') {
            $options[CURLOPT_POST] = TRUE;
            $options[CURLOPT_POSTFIELDS] = $data;
        }

        // Set headers
        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($response === FALSE) {
            log_message('error', 'cURL Error: ' . $error);
            return FALSE;
        }

        return $response;
    }
}
