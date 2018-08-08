<?php
namespace edrard\Packadges;

Class ArrayStrConv
{
    public static function construct_string($array, $prepend = '', $sep = '|')
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, dot($value, $prepend.$key.$sep, $sep));
            } else {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }
    public static function construct_array($array,$t="|"){
        $new = [];
        foreach($array as $key => $val){
            $tmp = explode($t,$key);
            $new[$tmp[0]] = !isset($new[$tmp[0]]) ? [] : $new[$tmp[0]];
            $new[$tmp[0]] = _reconstruct_array($tmp,$val,$new[$tmp[0]]);
        }  
        return $new;  
    }
    private static function _reconstruct_array($keys,$val,$new){
        array_shift($keys); 
        if(!empty($keys)){ 
            reset($keys);
            $key = $keys[key($keys)];
            $new[$key] = !isset($new[$key]) ? [] : $new[$key];
            $new[$key] = _reconstruct_array($keys,$val,$new[$key]);
        }else{
            $new = $val;
        }
        return $new;
    }
}