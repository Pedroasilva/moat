<?php

namespace App\Helpers;

class Helper
{
    public function __construct() {}

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function pcPermute($items, $perms = array( ))
    {
        if (empty($items)) {
            $return = array($perms);
        }  else {
            $return = array();
            for ($i = count($items) - 1; $i >= 0; --$i) {
                 $newitems = $items;
                 $newperms = $perms;
             list($foo) = array_splice($newitems, $i, 1);
                 array_unshift($newperms, $foo);
                 $return = array_merge($return, pc_permute($newitems, $newperms));
             }
        }
        return $return;
    }

    public function numberCombination($k,$n)
    {
        $n = intval($n);
        $k = intval($k);
        if ($k > $n){
            return 0;
        } elseif ($n == $k) {
            return 1;
        } else {
            if ($k >= $n - $k){
                $l = $k+1;
                for ($i = $l+1 ; $i <= $n ; $i++)
                    $l *= $i;
                $m = 1;
                for ($i = 2 ; $i <= $n-$k ; $i++)
                    $m *= $i;
            } else {
                $l = ($n-$k) + 1;
                for ($i = $l+1 ; $i <= $n ; $i++)
                    $l *= $i;
                $m = 1;
                for ($i = 2 ; $i <= $k ; $i++)
                    $m *= $i;            
            }
        }
        return $l/$m;
    }

    public function arrayCombination($le, $set)
    {
        $lk = self::numberCombination($le, count($set));
        $ret = array_fill(0, $lk, array_fill(0, $le, '') );
    
        $temp = array();
        for ($i = 0 ; $i < $le ; $i++)
            $temp[$i] = $i;
    
        $ret[0] = $temp;
    
        for ($i = 1 ; $i < $lk ; $i++){
            if ($temp[$le-1] != count($set)-1){
                $temp[$le-1]++;
            } else {
                $od = -1;
                for ($j = $le-2 ; $j >= 0 ; $j--)
                    if ($temp[$j]+1 != $temp[$j+1]){
                        $od = $j;
                        break;
                    }
                if ($od == -1)
                    break;
                $temp[$od]++;
                for ($j = $od+1 ; $j < $le ; $j++)    
                    $temp[$j] = $temp[$od]+$j-$od;
            }
            $ret[$i] = $temp;
        }
        for ($i = 0 ; $i < $lk ; $i++)
            for ($j = 0 ; $j < $le ; $j++)
                $ret[$i][$j] = $set[$ret[$i][$j]];   
    
        return $ret;
    }

    public function pc_array_shuffle($array) {
        $i = count($array);
        while(--$i) {
            $j = mt_rand(0, $i);
            if ($i != $j) {
                // swap elements
                $tmp = $array[$j];
                $array[$j] = $array[$i];
                $array[$i] = $tmp;
            }
        }
        return $array;
    } 

    public function monthStart()
    {
        $_month_start = new \DateTime('first day of this month');
        return $_month_start->format('Y-m-d');
    }

    public function monthEnd()
    {
        $_month_end = new \DateTime('last day of this month');
        return $_month_end->format('Y-m-d');
    }

    public function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}