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
        $info = \curl_getinfo($ch);
        \curl_close($ch);

        $httpCode = \intval($info['http_code']);

        if ($httpCode !== 200) {
            throw new \Exception('http error returned');
        }

        return $response;
    }
}
