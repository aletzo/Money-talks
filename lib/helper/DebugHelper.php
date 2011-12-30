<?php

class DebugHelper
{
    public static function log($data)
    {
        $root = dirname(dirname(dirname(__FILE__)));
        
        $filename = $root . '/log/debug.dat';
        $fp = fopen($filename, 'a');
        
        if (is_array($data)) {
            $data = 'array: ' . json_encode($data);
        }

        if (is_object($data)) {
            $data = 'object ' . get_class($data) . ': ' . json_encode(get_object_vars($data));
        }
        
        $data = date("Y M d, H:i:s")." --- " . $data;
        $data .= "\n\n=====================\n\n";
        fwrite($fp, $data);
        fclose($fp);
    }
    
    public static function getRawSql(Doctrine_Query $q)
    {
        $sql = $q->getSqlQuery();
        $flattenedParams = array_reverse($q->getFlattenedParams());
        
        $value = array_pop($flattenedParams);
        
        while(!is_null($value)) {
            $sql = preg_replace('/\?/', $value, $sql, 1);
            $value = array_pop($flattenedParams);
        }
        
        return $sql;
    }
    
    public static function alert($string)
    {
        echo '<script type="text/javascript">alert(' . $string . ')</script>';
    }

    public static function consoleLog($string)
    {
        echo '<script type="text/javascript">console.log(' . $string . ')</script>';
    }

}
