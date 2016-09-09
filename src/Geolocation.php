<?php


namespace Littie\Geolocation;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Mockery\CountValidator\Exception;

class Geolocation
{
    const URI = 'https://maps.googleapis.com/maps/api/geocode/';
    const GEOLOCATION = 'geolocation';
    const REVERSE_GEOLOCATION = 'reverse';
    const ADDRESS = 'address';
    const LATLNG = 'latlng';

    private $coordinates;
    private $response;
    private $method;
    private $key;
    private $verify;
    private $language;
    private $format;
    private $type;


    public function __construct($coordinates, $type)
    {
        $this->fetchData($coordinates, $type);
    }

    /* Get geolocation data */
    public function getGeolocationCoordinates() {
        return $this->getResult()['results'][0]['geometry']['location'];
    }

    /* Get reverse geolocation data */
    public function getReverseCoordinates() {
        $results = [];

        $data = $this->getResult()['results'];

        foreach ($data as $item) {
            $results[] = $item['formatted_address'];
        }

        return $results;
    }

    private function getResult() {
        $query = self::URI . $this->format . '?' . $this->type . '=' . $this->coordinates . '&' . 'language=' . $this->language . '&' . 'key=' . $this->key;
        
        /* Check cache */
        if (Cache::has($query)) {
            return Cache::get($query);
        }

        $client = new Client();

        $this->response = $client->request($this->method, $query , ['verify' => $this->verify]);
        
        /* Set cache */
        Cache::add($query, json_decode($this->response->getBody(), true), 1440);

        return json_decode($this->response->getBody(), true);
    }

    /* Fetch all data*/
    private function fetchData($coordinates, $type)
    {
        $this->coordinates = $coordinates;

        $this->method = config('geolocation.method');
        $this->key = config('geolocation.key');
        $this->verify = config('geolocation.verify');
        $this->language = config('geolocation.language');
        $this->format = config('geolocation.format');

        switch ($type) {
            case self::GEOLOCATION : $this->type = self::ADDRESS;
                break;
            case self::REVERSE_GEOLOCATION : $this->type = self::LATLNG;
                break;
            default: throw new Exception();
        }
    }
}