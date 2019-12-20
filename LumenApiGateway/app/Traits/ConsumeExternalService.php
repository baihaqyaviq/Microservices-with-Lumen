<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalService
{
    /**
     * Send request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        // dd($this->baseUri);
        $client = new Client([
            'base_uri'  =>  $this->baseUri,
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false, 
                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => fopen('php://temp', 'w+'),
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1],
            'timeout' => 45,
            'connect_timeout' => 45,
            'verify' => false, 
            // 'debug' => true,
            'exceptions' => false
        ]);

        // dd($client);

        if(isset($this->secret))
        {
            $headers['Authorization'] = $this->secret;
        }

        // dd($method, $requestUrl, $headers);

        $response = $client->request($method, $requestUrl, [
            'debug'       => true,
            'form_params' => $formParams,
            'headers'     => $headers,
        ]);
        // dd($response->getBody()->getContents());

        return $response->getBody()->getContents();
    }
}