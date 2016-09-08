<?php


namespace Littie\Geolocation\Facade;


use Illuminate\Support\Facades\Facade;

class Geolocation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geolocation';
    }
}