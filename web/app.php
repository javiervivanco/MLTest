<?php 

require '../vendor/autoload.php';

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
use Weather\Weather;
use Graph\Draw;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
$sun       = new Sun();
$planet_1  = new Planet('Ferengi',   $sun, deg2rad(1), 500, true);
$planet_2  = new Planet('Betasoide', $sun, deg2rad(5), 1000, true);
$planet_3  = new Planet('Vulcano',   $sun, deg2rad(3), 2000, false);   
$weather   = new Weather($sun);
$draw      = new Draw($sun);

function weather_label($clima_dia){
    switch ($clima_dia) {
    case Weather::RAINY:
        return 'Lluvioso';
        break;                    
    case Weather::MAX_RAINY:
        return 'Pico maximo de lluvias';
        break;
    case Weather::DROUGHT:
        return 'Sequia';
        break;
    case Weather::OPTIMUS:
        return 'Condiciones optimas';
        break;                
    case Weather::NORMAL:
        return 'Normal';
        break;
}

}

$app = new Silex\Application(); 
$app['debug'] = true;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/', function() use($app) {
    return file_get_contents("homepage.html");
}) ;



$app->get('/pronostico_extendido', function() use($app, $weather) {
    $stream = function () use ($weather){
        echo sprintf("Día, Estado\n");
        for ($i=0; $i <= 3600; $i++) { 
            echo sprintf("%s, %s\n", $i, weather_label($weather->getByDay($i)));
        }        
    };
    $h['Content-Type'] = 'text/csv';
    $h['Content-Disposition'] = 'attachment; filename=pronostico_extendido.csv';
    return $app->stream($stream, 200, $h);

}) ;

$app->get('/clima/{dia}', function($dia) use($app, $weather) { 
    $clima_dia = $weather->getByDay($dia);
    $clima['dia'] = $dia;
    $clima['clima'] = weather_label($clima_dia);
    $clima['graph'] = $app['url_generator']
        ->generate('graph',array('dia'=> $dia), UrlGeneratorInterface::ABSOLUTE_URL);
    return $app->json($clima);

});

$app->get('/clima/ver/{dia}', function($dia) use($app, $draw) { 
    $file=$draw->drawADay($dia);
    
    if (!file_exists($file)) {
        return $app->abort(404, 'The image was not found.');
    }

    $stream = function () use ($file) {
        readfile($file);
    };
    return $app->stream($stream, 200, array('Content-Type' => 'image/gif'));

})->bind('graph');; 

$app->run(); 