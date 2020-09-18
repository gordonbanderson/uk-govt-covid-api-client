<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Transport;

class Http
{

    public const ENDPOINT = 'https://api.coronavirus.data.gov.uk/v1/data';

    /**
     * Execute a request
     *
     * @return bool|string
     */
    public function request(string $jsonurl)
    {
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, \str_replace(' ', '%20', $jsonurl));
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'GET');
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
        $response = \curl_exec($ch);
        \curl_close($ch);

        return $response;
    }
}
