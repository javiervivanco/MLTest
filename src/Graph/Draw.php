<?php
namespace Graph;

use PlanetarySystem\Sun;
class Draw {
    protected $sun;
    public function __construct(Sun $sun){
        $this->sun = $sun;
    }
    public function drawADay($day, $path='/tmp/%s.gif'){
 
        $image = new \Imagick(); 
        $draw = new \ImagickDraw(); 
        $pixel['y'] = new \ImagickPixel('yellow'); 
        $pixel['r'] = new \ImagickPixel('red'); 
        $pixel['g'] = new \ImagickPixel('green'); 
        $pixel['b'] = new \ImagickPixel('blue'); 
        $image->newImage(5000, 5000, 'black', 'gif'); 

        // Here comes the magick: 
        $name = '';
        $draw->setFillColor($pixel['y']); 
        $planets = $this->sun->getPlanets();
        $draw->circle(2495,2495,2505,2505); 
        foreach ($planets as $planet) {
            $draw->setFillColor(next($pixel)); 
            $pos = $planet->getPositionCartesianByDay($day);
            $name .= $planet->getName();
            $draw->circle($pos->x+2495,$pos->y+2495,$pos->x+2505,$pos->y+2505 ); 
        }
        $name .= '_'.$day;
        $image->drawImage($draw); 
        $image->writeImages(sprintf($path, $name), true); 
        $image->clear();
    }

    public function drawRangeDays($from_day, $to_day){
        for ($i=$from_day; $i <=$to_day ; $i++) { 
            $this->drawADay($i);
        }

        $multiTIFF = new \Imagick();
        $mytifspath = "/tmp/gif";
        $files = scandir($mytifspath);

        foreach ($files as $key => $value) {
            if(in_array($value, array('.','..')))continue;
            echo $value;
            echo "\n";
            $auxIMG = new \Imagick();
            $auxIMG->readImage("/tmp/gif/".$value);
            $multiTIFF->addImage($auxIMG);
            $auxIMG->clear();
        }

        $multiTIFF->writeImages('/tmp/animate1.gif', true); 
        $multiTIFF->writeImages('/tmp/animate2.gif', false); 

    }
}