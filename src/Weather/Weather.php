<?php
namespace Weather;

use PlanetarySystem\Sun;
use Alignment;
class Weather {
    
    const RAINY             =1;
    const MAX_RAINY         =2;
    const DROUGHT           =3;
    const OPTIMUS           =4;
    const NORMAL            =5;


    protected $sun;
    
    public function __construct(Sun $sun){
        $this->sun = $sun;
    }
    public function getByDay($day){
        $align_sun     = new Alignment\IncludeSun();
        $align_not_sun = new Alignment\ExcludeSun();
        if($align_sun->isAlignment($day, $this->sun)){
            return self::DROUGHT;
        }
        if($this->sun->areSunInsidePlanetsByDay($day)){
            if($day>0){
                $perimeter_current = $this->sun->getPerimeterPlanetsByDay($day);
                $perimeter_prev    = $this->sun->getPerimeterPlanetsByDay($day-1);
                $perimeter_next    = $this->sun->getPerimeterPlanetsByDay($day+1);
                if($perimeter_current > $perimeter_prev && $perimeter_current > $perimeter_next){
                    return self::MAX_RAINY;
                }
                
            }
            return self::RAINY;
        }
        if($align_not_sun->isAlignment($day, $this->sun)){
            return self::OPTIMUS;
        }
        #throw new \Exception("Sin Condiciones climaticas");
        return self::NORMAL;
    }

}