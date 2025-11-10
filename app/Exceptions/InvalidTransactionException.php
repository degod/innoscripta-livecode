<?php

namespace App\Exceptions;

use Exception;

class InvalidTransactionException extends Exception
{
    public $service_url;
    public  $bearer_token;

    public function __construct()
    {
        $this->service_url = env('TRANX_API_URL');
        $this->bearer_token = env('TRANX_BEARER_TOKEN');
    }

    public function report()
    {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Token ' . $this->api_token,

        );
        curl_setopt($ch, CURLOPT_URL, $this->service_url . '/{id}/report');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $res = curl_exec($ch);
        \Log::info($res);
    }
}
