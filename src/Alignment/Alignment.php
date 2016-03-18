<?php 

namespace Alignment;

use PlanetarySystem\Sun;

abstract class Alignment{

    public function getTangsSinus($day, Sun $sun){
        $planets = $sun->getPlanets();
        $tangs   = array();
        $point_y   = array();
        $point_x   = array();
        $sinus   = array();
        foreach ($planets as $planet) {
            $pos     =  $planet->getPositionCartesianByDay($day);
            $arc     =  $planet->getPositionByDay($day);
            if($arc==M_PI){ # fix php seno 180
                $arc=0;
            }
            $point_x[] = $pos->x;
            $point_y[] = $pos->y;
            $sinus[]   = round(abs(sin($arc)), 5);

        }
        foreach ($point_x as $k => $x) {
            $n = $k+1;
            if(!isset($point_x[$n])){
                break;
            }
            $d_x = ($x-$point_x[$n]);
            $d_y = ($point_y[$k]-$point_y[$n]);
            if($d_x==0){
                $tangs[] = 0;
                continue;    
            }
            $tang=$d_y/$d_x;
            $tangs[] = round($tang,2);
        }
        $ctangs = array_unique($tangs);
        $csinus = array_unique($sinus);
        $return = new \stdClass();
        $return->tangs = $ctangs;
        $return->sinus = $csinus;
        return $return;
    }
    abstract public function isAlignment($day, Sun $sun);
}