<?php 

require '../vendor/autoload.php';

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
use Weather\Weather;
$sun       = new Sun();
$planet_1  = new Planet('Ferengi',   $sun, deg2rad(1), 500, true);
$planet_2  = new Planet('Betasoide', $sun, deg2rad(5), 1000, true);
$planet_3  = new Planet('Vulcano',   $sun, deg2rad(3), 2000, false);   
$weather   = new Weather($sun);

$app = new Silex\Application(); 

$app->get('/', function() use($app) {

}) ;

$app->get('/clima/{dia}', function($dia) use($app, $weather) { 
    $clima_dia = $weather->getByDay($dia);
    switch ($clima_dia) {
        case Weather::RAINY:
            $clima_dia='Lluvioso';
            break;                    
        case Weather::MAX_RAINY:
            $clima_dia='Pico maximo de lluvias';
            break;
        case Weather::DROUGHT:
            $clima_dia='Sequia';
            break;
        case Weather::OPTIMUS:
            $clima_dia='Condiciones optimas';
            break;                
        case Weather::NORMAL:
            $clima_dia='Normal';
            break;
    }
    $clima['dia'] = $dia;
    $clima['clima'] = $clima_dia;
    return $app->json($clima);

}); 

$app->run(); 