<?php

namespace fffaraz\Utils;

class Str
{
    public static function equals($str1, $str2)
    {
        return strtolower($str1) == strtolower($str2);
    }

    public static function splitLines($data)
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', $data))));
    }

    public static function contains($needle, $haystack)
    {
        return strpos(strtolower($haystack), strtolower($needle)) !== false;
    }

    public static function containsAny($needles, $haystack)
    {
        $haystack = strtolower($haystack);
        $needles = array_map('strtolower', $needles);
        foreach ($needles as $needle) if (strpos($haystack, $needle) !== false) return true;
        return false;
    }

    public static function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return substr($string, 0, $len) === $startString;
    }

    public static function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) return true;
        return substr($string, -$len) === $endString;
    }

    public static function isJson($string)
    {
        // https://stackoverflow.com/questions/6041741/fastest-way-to-check-if-a-string-is-json-in-php
        if (!is_string($string)) return false;
        if (strlen($string) < 2) return false;
        if ($string[0] != '{' || $string[0] != '[') return false; // TODO: trim?
        $json = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function mb_trim($string, $charlist = null)
    {
        if (is_null($charlist)) return trim ($string);
        $charlist = str_replace ('/', '\/', preg_quote ($charlist));
        return preg_replace ("/(^[$charlist]+)|([$charlist]+$)/us", '', $string);
    }

    // https://stackoverflow.com/questions/13884178/str-word-count-function-doesnt-display-arabic-language-properly
    public static function mb_str_word_count($string, $format = 0, $charlist = '[]')
    {
        $string = trim($string);
        if(empty($string)) $words = [];
        else
        {
            $words = preg_split('~[^\p{L}\p{N}\']+~u', $string);
            /*
            mb_internal_encoding('UTF-8');
            mb_regex_encoding('UTF-8');
            $words = mb_split('[^\x{0600}-\x{06FF}]', $string);
            */
        }
        switch ($format)
        {
            case 0: return count($words);
            case 1:
            case 2: return $words;
            default: return $words;
        }
    }

    public static function countWords($text, &$word2count, $ignored = [], $filter = null)
    {
        $words = Str::mb_str_word_count($text, 1);
        foreach ($words as $word)
        {
            if (is_callable($filter)) $word = $filter($word);
            if (substr($word, 0, 4) === 'http') continue;
            if (mb_strlen($word) < 2) continue;
            if (in_array($word, $ignored)) continue;
            if (!isset($word2count[$word])) $word2count[$word] = 0;
            $word2count[$word] = $word2count[$word] + 1;
        }
    }
}
