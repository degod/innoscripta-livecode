<?php

namespace App\Services;

class FetchTransactionService
{
    public $service_url;
    public $api_token;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->service_url = env('TRANX_API_URL');
        $this->api_token = env('TRANX_API_TOKEN');
    }

    public function doFetch()
    {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Token ' . $this->api_token,

        );
        curl_setopt($ch, CURLOPT_URL, $this->service_url . '?include[]=transactions&page=1&limit=10');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $res = curl_exec($ch);

        $this->processResponse($res);
    }

    public function processResponse($response)
    {
        $data = json_decode($response, true);
        $invoiceService = new InvoiceService();

        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $invoiceData) {
                $invoiceService->createInvoiceWithTransactions($invoiceData);
            }
        } else {
            // \Log::error('Invalid response structure: ' . $response);
        }
    }
}
