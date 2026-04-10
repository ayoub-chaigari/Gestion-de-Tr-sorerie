<?php

namespace App\Helpers;

class NumberToWords
{
    private static $units = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
    private static $teens = ['dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];
    private static $tens = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];

    public static function convert($number)
    {
        if ($number == 0) return 'zéro';

        $parts = explode('.', number_format($number, 2, '.', ''));
        $integerPart = (int)$parts[0];
        $decimalPart = (int)$parts[1];

        $result = self::toWords($integerPart);
        $result .= ($integerPart > 1) ? ' dirhams' : ' dirham';

        if ($decimalPart > 0) {
            $result .= ' et ' . self::toWords($decimalPart);
            $result .= ($decimalPart > 1) ? ' centimes' : ' centime';
        }

        return ucfirst(trim($result));
    }

    private static function toWords($number)
    {
        if ($number < 10) return self::$units[$number];
        if ($number < 20) return self::$teens[$number - 10];
        
        if ($number < 100) {
            $ten = (int)($number / 10);
            $unit = $number % 10;
            
            if ($ten == 7) {
                return 'soixante-' . ($unit == 1 ? 'et-onze' : self::$teens[$unit]);
            }
            if ($ten == 8) {
                return 'quatre-vingt' . ($unit == 0 ? 's' : '-' . self::$units[$unit]);
            }
            if ($ten == 9) {
                return 'quatre-vingt-' . self::$teens[$unit];
            }
            
            $text = self::$tens[$ten];
            if ($unit > 0) {
                $text .= ($unit == 1 ? '-et-un' : '-' . self::$units[$unit]);
            }
            return $text;
        }

        if ($number < 1000) {
            $hundred = (int)($number / 100);
            $rest = $number % 100;
            
            $text = ($hundred == 1) ? 'cent' : self::$units[$hundred] . ' cents';
            if ($rest > 0) {
                // Remove 's' from cents if followed by more numbers
                if ($hundred > 1) $text = substr($text, 0, -1);
                $text .= ' ' . self::toWords($rest);
            }
            return $text;
        }

        if ($number < 1000000) {
            $thousand = (int)($number / 1000);
            $rest = $number % 1000;
            
            $text = ($thousand == 1) ? 'mille' : self::toWords($thousand) . ' mille';
            if ($rest > 0) {
                $text .= ' ' . self::toWords($rest);
            }
            return $text;
        }

        if ($number < 1000000000) {
            $million = (int)($number / 1000000);
            $rest = $number % 1000000;
            
            $text = self::toWords($million) . ($million > 1 ? ' millions' : ' million');
            if ($rest > 0) {
                $text .= ' ' . self::toWords($rest);
            }
            return $text;
        }

        return (string)$number;
    }
}
