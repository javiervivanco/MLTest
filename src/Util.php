<?php

class Util {

 
    static public function getQuadrant($rad){
        if($rad == M_PI*2 || $rad===0){
            return 1;
        }
        for ($i=1; $i <=4 ; $i++) { 
            if($rad >= M_PI_2*($i-1) && $rad < M_PI_2*$i){
                return $i;
            }
        }

    }
}