<?php


namespace Littie\Geolocation;


use GuzzleHttp\Client;

class Geolocation
{
    //todo: Вынести формат данных в конфиг
    const URI = 'https://maps.googleapis.com/maps/api/geocode/json?';
    const GEOLOCATION = 'geolocation';
    const REVERSE_GEOLOCATION = 'reverse';

    private $coordinates;
    private $response;
    private $method;
    private $key;
    private $verify;


    public function __construct($coordinates, $type)
    {
        $this->fetchData();
        $this->coordinates = $coordinates;

        if ($type == self::GEOLOCATION) {
            $this->response = $this->getGeolocationResponse();
        } else {
            $this->response = $this->getReverseResponse();
        }
    }

    public function getGeolocationCoordinates() {
        return json_decode($this->response->getBody(), true)['results'][0]['geometry']['location'];
    }

    public function getReverseCoordinates() {
        $results = [];

        $data = json_decode($this->response->getBody(), true)['results'];

        foreach ($data as $item) {
            $results[] = $item['formatted_address'];
        }

        return $results;
    }

    private function getReverseResponse()
    {
        $client = new Client();

        return $client->request($this->method, self::URI . 'latlng=' . $this->coordinates . '&' . 'key=' . $this->key, ['verify' => $this->verify]);
    }

    private function getGeolocationResponse()
    {
        $client = new Client();

        return $client->request($this->method, self::URI . 'address=' . $this->coordinates . '&' . 'key=' . $this->key, ['verify' => $this->verify]);
    }

    private function fetchData()
    {
        $this->method = config('geolocation.method');
        $this->key = config('geolocation.key');
        $this->verify = config('geolocation.verify');
    }

    public static function saySomething()
    {
        return config('geolocation.message');
    }
}