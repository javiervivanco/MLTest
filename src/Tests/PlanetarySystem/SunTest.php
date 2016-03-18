|<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
 
class SunTest extends \PHPUnit_Framework_TestCase {


    public function setUp(){}
    public function tearDown(){}
 
    public function testSunInsidePlanet(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);

        $this->assertFalse($sun->areSunInsidePlanetsByDay(0));
        $this->assertTrue($sun->areSunInsidePlanetsByDay(42));
        $this->assertFalse($sun->areSunInsidePlanetsByDay(180));
       
        $this->assertFalse($sun->areSunInsidePlanetsByDay(360));
        
    }
    
    public function testSunOutsidePlanet(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);

        $this->assertTrue($sun->areSunOutsidePlanetsByDay(0));
        $this->assertTrue($sun->areSunOutsidePlanetsByDay(45));
        $this->assertTrue($sun->areSunOutsidePlanetsByDay(180));
        $this->asserttrue($sun->areSunOutsidePlanetsByDay(359));
        $this->assertTrue($sun->areSunOutsidePlanetsByDay(360));
        
    }
    public function testSunPerimeterPlanetsByDay(){
        $sun    = new Sun();
        $p_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $p_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $p_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);

        $this->assertEquals(5899.41979, $sun->getPerimeterPlanetsByDay(55));
    }    
    public function testSunPerimeterAlignPlanetsByDay(){
        $sun    = new Sun();
        $p_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $p_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $p_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);

        $this->assertEquals($p_2->getRadio() + $p_3->getRadio(),
                $sun->getPerimeterPlanetsByDay(0));
        $this->assertEquals($p_2->getRadio()+ $p_3->getRadio(),
                $sun->getPerimeterPlanetsByDay(90));
        $this->assertEquals($p_2->getRadio()+ $p_3->getRadio(),
                $sun->getPerimeterPlanetsByDay(180));
        $this->assertEquals($p_2->getRadio()+ $p_3->getRadio(),
                $sun->getPerimeterPlanetsByDay(270));
        $this->assertEquals($p_2->getRadio()+ $p_3->getRadio(),
                $sun->getPerimeterPlanetsByDay(360));
    }


}