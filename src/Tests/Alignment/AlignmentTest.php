|<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;
 
class AlignmentTest extends \PHPUnit_Framework_TestCase {
    public function testPlanetsAlignmentZeroDay(){
        $sun         = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 540, false);
        $planet_2    = new Planet('P2', $sun, deg2rad(4), 1200, false);
        $planet_3    = new Planet('P3', $sun, deg2rad(5), 1600, true);
        $is_alignment = new Alignment\IncludeSun();
        $this->assertTrue($is_alignment->isAlignment(0, $sun));
    }    
    public function testPlanetsAlignmentWithSun(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);
        $is_alignment = new Alignment\IncludeSun();
        $this->assertTrue($is_alignment->isAlignment(0, $sun));
        $this->assertTrue($is_alignment->isAlignment(45, $sun));
        $this->assertTrue($is_alignment->isAlignment(180, $sun));        
        $this->assertTrue($is_alignment->isAlignment(360, $sun));
    }
    public function testPlanetsAlignmentWithSunDiffentQuadrant(){
        $sun       = new Sun();
        $planet_1    = new Planet('P1', $sun, deg2rad(69), 500, false);
        $planet_2    = new Planet('P2', $sun, deg2rad(13), 1000, false);
        $planet_3    = new Planet('P3', $sun, deg2rad(28), 2000, true);
        $is_alignment = new Alignment\IncludeSun();
        $this->assertTrue($is_alignment->isAlignment(2340, $sun));
    }

    public function testPlanetsAlignmentWithoutSun(){
        $sun             = new Sun();
        $is_alig_sun     = new Alignment\IncludeSun();
        $is_alig_not_sun = new Alignment\ExcludeSun();
        $planet_1    = new Planet('P1', $sun, deg2rad(1), 500, true);
        $planet_2    = new Planet('P2', $sun, deg2rad(5), 1000, true);
        $planet_3    = new Planet('P3', $sun, deg2rad(3), 2000, false);
        $this->assertTrue($is_alig_not_sun->isAlignment(73, $sun));
        $this->assertFalse($is_alig_not_sun->isAlignment(180, $sun));
        $this->assertFalse($is_alig_not_sun->isAlignment(0, $sun));
        $this->assertFalse($is_alig_not_sun->isAlignment(45, $sun));
        $this->assertFalse($is_alig_not_sun->isAlignment(270, $sun));
        $this->assertTrue($is_alig_sun->isAlignment(45, $sun));
    }
 


}