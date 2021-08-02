<?php

namespace CoinDesk\Utils;

/**
 * ApiRequest
 *
 * @link    https://github.com/shahradelahi/coindesk-ticker
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/coindesk-ticker/blob/master/LICENSE (MIT License)
 */
class ApiRequest
{

    /**
     * @var string
     */
    private string $apiPath = "https://api.coindesk.com/v1/";

    /**
     * @var array|string[]
     */
    private array $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Pragma: ' => 'no-cache'
    ];

    /**
     * @param string $endpoint
     * @param array $parameters
     * @return array
     */
    public function sendRequest(string $endpoint, array $parameters = []): array
    {
        $queryString = http_build_query($parameters); // query string encode the parameters

        $endPointUrl = $this->apiPath . $endpoint . "?" . $queryString; // create the request URL

        $curl = curl_init(); // Get cURL resource

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endPointUrl,              // set the request URL
            CURLOPT_HTTPHEADER => $this->headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1               // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request

        return json_decode($response, true);
    }

}
