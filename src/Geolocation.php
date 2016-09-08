<?php


namespace Littie\Geolocation;


class Geolocation
{
    public static function saySomething() {
        return config('geolocation.message');
    }
}