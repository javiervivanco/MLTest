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

    public function arePlanetsAlignmentWithoutSunOfDay($day){
        # build function
        if(count($this->planets)<2){
            return false;
        }
        reset($this->planets);
        $p1 = current($this->planets);
        $p2 = next($this->planets);
        $pos_p1=$p1->getPositionCartesianByDay($day);
        $pos_p2=$p2->getPositionCartesianByDay($day);
        
        $seg_x   = $pos_p2->x - $pos_p1->x;
        $seg_y   = $pos_p2->y - $pos_p1->y;
        $y_1     = $pos_p1->y;
        $x_1     = $pos_p1->x;
        $tang_w  = $seg_y/$seg_x;

        # funcion lineal y = x*m+b
        # funcion lineal x = y*m+c
        $function = function ($x,$y) use ($tang_w, $x_1, $y_1, $day) {
            return $y == $tang_w*($x - $x_1) + $y_1;
        } ;
        while ($p_n = next($this->planets)) {
            $pos_pn=$p_n->getPositionCartesianByDay($day);
            if($function ($pos_pn->x, $pos_pn->y)===false){
                return false;
            }

        }
        # pasa por cero
        if($function(0,0)){
            return false;
        }
        reset($this->planets);
        return true;

    }

    public function arePlanetsAlignmentWithSunOfDay($day){
        $angles= array();
        foreach ($this->planets as $name => $planet) {
           $angles[$name] =  $planet->getPositionByDay($day);
        }
        $angles = array_unique($angles);
        if(count($angles)===1){
            return true;
        }
        # Diff Qua
        $quadrant = array();
        foreach ($angles as $name => $ang) {
            $quadrant[$name] = \Util::getQuadrant($ang);
        }
        $unique_quadrant = array_unique(array_values($quadrant));
        sort($unique_quadrant);
        if($unique_quadrant==array(1,3)){
            $check_angles= array();
            foreach ($angles as $name => $ang) {
                switch ($quadrant[$name]) {
                    case 1:
                        $check_angles[$name] = M_PI_2-$ang;
                        break;
                    case 3:
                        $check_angles[$name] = (M_PI*(3/2))-$ang;
                        break;
                }
            }
            $check_angles = array_unique($check_angles);
            if(count($check_angles)===1){
                return true;
            }
        }
        if($unique_quadrant==array(2,4)){
            $check_angles= array();
            foreach ($angles as $name => $ang) {
                switch ($quadrant[$name]) {
                    case 2:
                        $check_angles[$name] = M_PI-$ang;
                        break;
                    case 4:
                        $check_angles[$name] = (M_PI*2)-$ang;
                        break;
                }
            }
            $check_angles = array_unique($check_angles);
            if(count($check_angles)===1){
                return true;
            }
        }
        return false;
    }
    public function areSunOutsidePlanetsByDay($day){
        return $this->areSunInsideOrOutsideInPlanetsByDay($day) == 'outside';
    }    

    public function areSunInsidePlanetsByDay($day){
       $are_in = $this->areSunInsideOrOutsideInPlanetsByDay($day);
       return in_array($are_in, array('boundary', 'inside'));
    }

    public function areSunInsideOrOutsideInPlanetsByDay($day){
        $checker = new \pointLocation();
        $poligon = array();
        foreach ($this->planets as $name => $planet) {
            $pos = $planet->getPositionCartesianByDay($day);
            $poligon[] = sprintf('%f %f', $pos->x, $pos->y);
        }

        $return=$checker->pointInPolygon('0 0', $poligon);

        return $return;
    }
}