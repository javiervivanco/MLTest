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
        $width    = 400;
        $height   = 400;
        $width_2  = $width/2;
        $offset   = 0.5;
        $width_2u = $width_2+$offset;
        $width_2d = $width_2-$offset;
        $height_2 = $height/2;
        $height_2u=$height_2+$offset;
        $height_2d=$height_2-$offset;

        $zoom   = 13;
        $image->newImage($width, $height, 'grey', 'gif'); 

        // Here comes the magick: 
        $name = '';
        $draw->setFillColor($pixel['y']); 
        $planets = $this->sun->getPlanets();
        $draw->circle($width_2d-2,$height_2d-2,$width_2u+2,$height_2u+2); 
        foreach ($planets as $planet) {
            $draw->setFillColor(next($pixel)); 
            $pos = $planet->getPositionCartesianByDay($day);
            $name .= $planet->getName();
            $draw->circle($pos->x/$zoom+$width_2d,$pos->y/$zoom+$height_2d,$pos->x/$zoom+$width_2u,$pos->y/$zoom+$height_2u ); 
        }
        $name .= '_'.$day;
        $image->drawImage($draw); 
        $file = sprintf($path, $name);
        $image->writeImages($file, true); 
        $image->clear();
        return $file;
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