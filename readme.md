## Geolocation package <br>

### 1) Install package <br>

<ul>
<li>Add <strong>"littie/geolocation": "~0.0"</strong> in your <strong>require-dev</strong> section of main composer.json progect file</li>
<li>Execute **composer update**</li>
</ul>

### 2) Config package

<ul>
<li> In your <strong>config/app.php</strong> file in provider array add GeolocationServiceProvider <br>
<strong>Littie\Geolocation\GeolocationServiceProvider::class</strong></li>
<li> In your <strong>config/app.php</strong> file in aliases array add Geolocation facade <br>
<strong>'Geolocation' => Littie\Geolocation\Facade\Geolocation::class</strong></li>
<li> In command line type <strong> php artisan vendor:publish </strong>. <br>
Its command add in your <strong>config</strong> folder <strong>geolocation.php</strong> file
</ul>

### Use package

<strong>Get geolocation:</strong> <br>
<code>
Route::get('geolocation', function() {<br>
    $geolocation = new Geolocation('1600 Amphitheatre Parkway, Mountain View, CA', 'geolocation');<br>
    dd($geolocation->getGeolocationCoordinates());
});
</code>

<strong>Get reverse geolocation:</strong> <br>
<code>
Route::get('reverse', function() {<br>
    $geolocation = new Geolocation('40.714224,-73.961452', 'reverse');<br>
    dd($geolocation->getReverseCoordinates());
</code><br>

Object geolocation receive two parameters, coordinates and type<br>
coordinates are coordinates which you want find
type is type of query, can be 'geolocation' for get coordinates and 'reverse' for get address

### Geolocation config file <br>
    'method' => 'GET' - query method
    'key' => '' - google API programm key
    'verify' => false - ssl sertificate
    'language' => 'ru' - results language
    'format' => 'json' - receive data format json or xml
