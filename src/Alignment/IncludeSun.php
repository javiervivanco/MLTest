<?php
namespace Alignment;
use PlanetarySystem\Sun;

class IncludeSun extends Alignment{

    public function isAlignment($day, Sun $sun){
        $tangs_sinus = $this->getTangsSinus($day, $sun);
        return (count($tangs_sinus->tangs)==1 && count($tangs_sinus->sinus)==1);
    }
} 