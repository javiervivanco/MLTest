<?php

namespace PlanetarySystem;

class Planet {

    protected $name;
    protected $sun;
    protected $angularVelocity;
    protected $radio;
    protected $clockwise;
    
    public function __construct($name, Sun $sun, $angularVelocity, $radio, $clockwise){
        $this->name = $name;
        $this->sun  = $sun;
        $sun->addPlanet($this);  
        $this->setAngularVelocity($angularVelocity);
        $this->setRadio($radio);
        $this->setClockwise($clockwise);
    }

    /**
     * @param type $AngularVelocity
     */
    public function setAngularVelocity($AngularVelocity)
    {
        $this->angularVelocity = $AngularVelocity;
        return $this;
    }
    
    /**
     * @return type
     */
    public function getAngularVelocity()
    {
        return $this->angularVelocity;
    }

    /**
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return type
     */
    public function getSun()
    {
        return $this->sun;
    }

    /**
     * @param type $radio
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;
        return $this;
    }
    /**
     * @return type
     */
    public function getRadio()
    {
        return $this->radio;
    }
    /**
     * @param type $clockwise
     */
    public function setClockwise($clockwise)
    {
        $this->clockwise = $clockwise;
        return $this;
    }
    /**
     * @return type
     */
    public function getClockwise()
    {
        return $this->clockwise;
    }

    public function getPositionCartesianByDay($day){
        $rad_pos = $this->getPositionByDay($day);
        $sin = sin($rad_pos);
        $cos = cos($rad_pos);
        $pos = new \stdClass();
        $pos->x = $this->radio*$cos;
        $pos->y = $this->radio*$sin;
        return $pos;
    }

    public function getPositionByDay($day){
        if(empty($day)){
            return 0;
        }
        $pos = M_PI/(M_PI/($this->angularVelocity*$day));
        if($pos > (2*M_PI)){
            $m = $pos/(2*M_PI);
            $float_part = $m - floor($m);
            $pos = $float_part*2*M_PI;
        }
        if($pos == (2*M_PI)){
            return 0;
        }
        if($this->clockwise && $pos > 0){
            return (2*M_PI)-$pos;
        }
        return $pos;
        
    }

}