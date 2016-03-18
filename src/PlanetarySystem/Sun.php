<?php
namespace PlanetarySystem;
/**
*  
*/
class Sun 
{
    
    protected $planets = array();

    /**
     * @param type $Planet
     */
    public function addPlanet(Planet $Planet)
    {
        $this->planets[$Planet->getName()] = $Planet;
        return $this;
    }
    public function getPlanets(){
        return $this->planets;
    }
 
 
    public function areSunOutsidePlanetsByDay($day){
        return $this->areSunInsideOrOutsideInPlanetsByDay($day) == 'outside';
    }    

    public function areSunInsidePlanetsByDay($day){
       $are_in = $this->areSunInsideOrOutsideInPlanetsByDay($day);
       
       return in_array($are_in, array('boundary', 'inside'));
    }

    public function areSunInsideOrOutsideInPlanetsByDay($day){

        $poligon = array();
        foreach ($this->planets as $name => $planet) {
            $poligon[] = $planet->getPositionCartesianByDay($day);
        }
        $zero = new \stdClass();
        $zero->x=0;
        $zero->y=0;
        $return=$this->pointInPolygon($zero, $poligon);

        return $return%2== 0 ? 'outside' : 'inside';
    }

    public function pointInPolygon($p, $polygon) {
        $c = 0;
        $p1 = $polygon[0];
        $n = count($polygon);

        for ($i=1; $i<=$n; $i++) {
            $p2 = $polygon[$i % $n];
            if ($p->x > min($p1->x, $p2->x)
                && $p->x <= max($p1->x, $p2->x)
                && $p->y <= max($p1->y, $p2->y)
                && $p1->x != $p2->x) {
                    $xinters = ($p->x - $p1->x) * ($p2->y - $p1->y) / ($p2->x - $p1->x) + $p1->y;
                    if ($p1->y == $p2->y || $p->y <= $xinters) {
                        $c++;
                    }
            }
            $p1 = $p2;
        }
        // if the number of edges we passed through is even, then it's not in the poly.
        return $c%2!=0;
    }

    public function getPerimeterPlanetsByDay($day){
        $point_y   = array();
        $point_x   = array();
        $segments  = array();
        foreach ($this->planets as $planet) {
            $pos     =  $planet->getPositionCartesianByDay($day);
            $point_x[] = $pos->x;
            $point_y[] = $pos->y;
        }
        $fnc_h= function ($x, $x_1, $y, $y_1){
            $d_x      = $x-$x_1;
            $d_y      = $y-$y_1;
            $h2       = pow($d_x, 2) + pow($d_y, 2);
            return sqrt($h2);
        };
        foreach ($point_x as $k => $x) {
            $n = $k+1;
            $y = $point_y[$k];
            if(!isset($point_x[$n])){
                $n=0;
            }
            $x_1 = $point_x[$n];
            $y_1 = $point_y[$n];
            $h   = $fnc_h($x, $x_1, $y, $y_1);
            $segments[] = $h;
        }
        return round(array_sum($segments),5);
    }
}