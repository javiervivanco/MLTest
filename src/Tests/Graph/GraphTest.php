<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
use Graph\Draw;

class GraphTest extends \PHPUnit_Framework_TestCase {
    public function testDraw(){        
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);
        $draw = new Draw($sun);
        for ($i=0; $i <= 360; $i++) { 
           # $draw->drawADay($i);
           # usleep(500);
        }
#        $draw->drawADay(90);
#        $draw->drawADay(270);
#           $draw->drawADay(45);
#           $draw->drawADay(73);
#           $draw->drawADay(107);
#           $draw->drawADay(253);
#           $draw->drawADay(287);
    }    
    public function testDrawAnimate(){
        $this->markTestSkipped('Skipping');
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);
        $draw = new Draw($sun);
        $draw->drawRangeDays(0,360);
    }
}
