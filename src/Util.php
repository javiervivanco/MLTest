<?php

class Util {

    static public function grad2Rad($grad){
        return (M_PI*$grad)/180;
    }

    static public function rad2Grad($rad){
        return (180*$rad)/M_PI;
    }

    static public function getQuadrant($rad){
        for ($i=1; $i <=4 ; $i++) { 
            if($rad >= M_PI_2*($i-1) && $rad < M_PI_2*$i){
                return $i;
            }
        }

    }
}