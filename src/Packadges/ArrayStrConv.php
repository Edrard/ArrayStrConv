<?php
namespace edrard\Packadges;

Class ArrayStrConv
{
    /**
    * Convert array multi array to one level array with complex key
    * 
    * @param array $array - array to convert 
    * @param string $prepend - prepend in front of complex key
    * @param string $sep - separator betwean keys
    * @param array $unset - unset deepes keys
    */
    public static function construct_string(array $array, $prepend = '', $sep = '|', $unset = array(), $keep_empty = FALSE)
    {
        static::unset_deep_keys($array,$unset);
        return self::_construct_string($array, $prepend, $sep,$keep_empty);
    }

    private static function _construct_string(array $array, $prepend = '', $sep = '|', $keep_empty = FALSE)
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, self::_construct_string($value, $prepend.$key.$sep, $sep,$keep_empty));
            } else {
                $results[$prepend.$key] =  $value;
                if(is_array($value)){     
                    if($keep_empty !== FALSE ){
                        $results[$prepend.$key] =  '';
                    }else{
                        unset($results[$prepend.$key]);    
                    }
                }
            }
        }
        return $results;
    }
    /**
    * Convert one level array with complex key to multi level
    * 
    * @param mixed $array - array to convert
    * @param string $prepend - prepend in front of complex key
    * @param mixed $t - separator
    */
    public static function construct_array(array $array, $prepend = '', $t="|"){
        $new = [];
        foreach($array as $key => $val){
            $key = preg_replace("/^(".$prepend.")/u", "", $key);
            $tmp = explode($t,$key);
            $new[$tmp[0]] = !isset($new[$tmp[0]]) ? [] : $new[$tmp[0]];
            $new[$tmp[0]] = self::reconstruct_array($tmp,$val,$new[$tmp[0]]);
        }  
        return $new;  
    }
    public static function unset_deep_keys(array &$array, array $keys = array()){
        if(!empty($keys)){
            if(is_array($array)){
                foreach ($array as $key => &$value) { 
                    if (is_array($value)) { 
                        static::unset_deep_keys($value, $keys); 
                    } else {
                        if (in_array($key, $keys)){
                            unset($array[$key]);
                        }
                    } 
                }
            }
        }
    } 
    private static function reconstruct_array(array $keys,$val,$new){
        array_shift($keys); 
        if(!empty($keys)){ 
            reset($keys);
            $key = $keys[key($keys)];
            $new[$key] = !isset($new[$key]) ? [] : $new[$key];
            $new[$key] = self::reconstruct_array($keys,$val,$new[$key]);
        }else{
            $new = $val;
        }
        return $new;
    }
}