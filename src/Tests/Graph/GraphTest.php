<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
use Graph\Draw;

class GraphTest extends \PHPUnit_Framework_TestCase {
    public function testDraw(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(3), 2000, false);
        $draw = new Draw($sun);
        $draw->drawADay(0);
    }    
    public function testDrawAnimate(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(3), 2000, false);
        $draw = new Draw($sun);
        $draw->drawRangeDays(0,360);
    }
}
