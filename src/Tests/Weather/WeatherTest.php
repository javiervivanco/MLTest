|<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
use Weather\Weather;
 
class WeatherTest extends \PHPUnit_Framework_TestCase {


    public function setUp(){}
    public function tearDown(){}
 
    public function testWeatherDrought(){
        $sun       = new Sun();
        $planet_1  = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2  = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3  = new Planet('P3', $sun, deg2rad(3), 2000, false);   
        $weather   = new Weather($sun);

        for ($i=0; $i < 360; $i++) { 
            $w = $weather->getByDay($i);
            switch ($w) {
                case Weather::RAINY:
                    echo "Dia: $i Llueve\n";
                    break;                    
                case Weather::MAX_RAINY:
                    echo "Dia: $i Max Llueve\n";
                    break;
                case Weather::DROUGHT:
                    echo "Dia: $i Seco\n";
                    break;
                case Weather::OPTIMUS:
                    echo "Dia: $i Optimo\n";
                    break;                
                case Weather::NORMAL:
                    echo "Dia: $i Normal\n";
                    break;

            }
        }

        
    }
    public function testWeatherRain(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);   
        
    }

    public function testWeatherMaxRain(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);   
        
    }

    public function testWeatherOptimus(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);   
        
    }

}