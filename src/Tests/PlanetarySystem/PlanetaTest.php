<?php

use PlanetarySystem\Sun;
use PlanetarySystem\Planet;

class PlanetTest extends \PHPUnit_Framework_TestCase {


    public function setUp(){}
    public function tearDown(){}

    public function testNewPlanet(){

        $name = 'Planet Test1';
        $ang_vel = Util::grad2Rad(10);
        $radio   = 100;
        $clockwise = true;
        $sun     = new Sun();
        $planet  = new Planet($name, $sun, $ang_vel, $radio, $clockwise);
        $planet->setAngularVelocity($ang_vel);
        $this->assertEquals($ang_vel, $planet->getAngularVelocity());
        $this->assertEquals($name, $planet->getName());
        $this->assertEquals($radio, $planet->getRadio());
        $this->assertEquals($clockwise, $planet->getClockwise());
    }

    public function testPositionRefSunByTime(){
        
        $grad       = 5;
        $days_in_year = 360/$grad;
        $rad_by_day = Util::grad2Rad($grad);
        $ang_vel   = Util::grad2Rad($grad);
        $clockwise = false;
        $radio     = 1000;
        $sun       = new Sun();
        $planet    = new Planet('T2', $sun, $ang_vel, $radio, $clockwise);
        for ($day=0; $day <=($days_in_year*10); $day++) { 
            $expect = $rad_by_day*$day;
            if($expect>2*M_PI){
                $m = $expect/(2*M_PI);
                $float_part = $m - floor($m);
                $expect = $float_part*2*M_PI;                
            }
            $expect = $expect==2*M_PI ? 0 : $expect;
            $this->assertEquals($expect,  $planet->getPositionByDay($day));
            }
    }
    public function testPositionRefSunByTimeClockwise(){        
        $ang_vel   = Util::grad2Rad(1);
        $clockwise = true;
        $radio     = 1000;
        $sun       = new Sun();
        $planet    = new Planet('T2', $sun, $ang_vel, $radio, $clockwise);
        for ($year=0; $year <= 10 ; $year++) { 
            $time = $year*360;
            $this->assertEquals(0,       $planet->getPositionByDay($time+0));
            $this->assertEquals(2*M_PI-(M_PI/6),  $planet->getPositionByDay($time+30));
            $this->assertEquals(2*M_PI-(M_PI/3),  $planet->getPositionByDay($time+60));
            $this->assertEquals(2*M_PI-(M_PI/2),  $planet->getPositionByDay($time+90));
            $this->assertEquals(M_PI,             $planet->getPositionByDay($time+180));
            $this->assertEquals(2*M_PI-(M_PI*1.5),$planet->getPositionByDay($time+270));
        }
    }
    public function testPositionCartesianByTime(){
        $ang_vel   = Util::grad2Rad(1);
        $clockwise = false;
        $radio     = 1000;
        $sun       = new Sun();
        $planet    = new Planet('T1', $sun, $ang_vel, $radio, $clockwise);
        $position_cartesian = $planet->getPositionCartesianByDay(45);

        $this->assertEquals((sqrt(2)/2)*1000,$position_cartesian->y);
        $this->assertEquals((sqrt(2)/2)*1000,$position_cartesian->x);

    }
}
