<?php

namespace App\Services;

class Censurator
{
    public function purify($value)
    {
        // Génère : You should eat pizza, beer, and ice cream every day
        $phrase  = "You should eat fruits, vegetables, and fiber every day.";
        $replace = array("con", "pute", "salope");
        $stars   = array("****", "****", "******");
        return str_ireplace($replace, $stars, $value);
    }

}