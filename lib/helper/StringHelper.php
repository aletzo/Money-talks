<?php

function ucfirst_utf8($stri)
{
    if($stri{0}>="\xc3") {
        return (($stri{1}>="\xa0") ?
            ($stri{0}.chr(ord($stri{1})-32)) :
            ($stri{0}.$stri{1})).substr($stri,2);
    } else {
        return ucfirst($stri);
    }
} 

function mb_ucase_first($str)
{
    DebugHelper::log('before: ' . $str);
    $str[0] = mb_strtoupper($str[0]);
    DebugHelper::log('after: ' . $str);
    return $str;
} 

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string) {
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }
}


function mb_ucase_words($str)
{
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    $words = array();

    foreach (explode(' ', $str) as $word) {
        //$words[] = mb_ucase_first($word);
        //$words[] = ucfirst_utf8($word);
        $words[] = mb_ucfirst($word);
    }

    return implode(' ', $words);
}

