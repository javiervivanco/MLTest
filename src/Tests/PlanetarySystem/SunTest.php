|<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;

class SunTest extends \PHPUnit_Framework_TestCase {


    public function setUp(){}
    public function tearDown(){}

    public function testPlanetsAlignmentZeroDay(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 540, false);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(4), 1200, false);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(5), 1600, true);
        $this->assertTrue($sun->arePlanetsAlignmentWithSunOfDay(0));
    }    
    public function testPlanetsAlignmentWithSunSameQuadrant(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, false);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(2), 1000, false);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(4), 2000, true);
        $this->assertTrue($sun->arePlanetsAlignmentWithSunOfDay(360));
    }
    public function testPlanetsAlignmentWithSunDiffentQuadrant(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(69), 500, false);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(13), 1000, false);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(28), 2000, true);

        $this->assertTrue($sun->arePlanetsAlignmentWithSunOfDay(2340));
    }

    public function testPlanetsAlignmentWithoutSun(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(3), 2000, false);

        $this->assertTrue($sun->arePlanetsAlignmentWithoutSunOfDay(45));
        $this->assertFalse($sun->arePlanetsAlignmentWithoutSunOfDay(180));
        $this->assertTrue($sun->arePlanetsAlignmentWithSunOfDay(180));
    }

    public function testSunInsidePlanet(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(3), 2000, false);

        $this->assertFalse($sun->areSunInsidePlanetsByDay(0));
        $this->assertTrue($sun->areSunInsidePlanetsByDay(45));
        $this->assertFalse($sun->areSunInsidePlanetsByDay(180));
        $this->assertTrue($sun->areSunInsidePlanetsByDay(359));
        $this->assertFalse($sun->areSunInsidePlanetsByDay(360));
        
    }
    public function testSunOutsidePlanet(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, Util::grad2Rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, Util::grad2Rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, Util::grad2Rad(3), 2000, false);

        $this->assertTrue($sun->areSunOutsidePlanetsByDay(0));
        $this->assertFalse($sun->areSunOutsidePlanetsByDay(45));
        $this->assertTrue($sun->areSunOutsidePlanetsByDay(180));
        $this->assertFalse($sun->areSunOutsidePlanetsByDay(359));
        $this->assertTrue($sun->areSunOutsidePlanetsByDay(360));
        
    }

}