<?php

namespace App\Traits;


trait HelperFunctions
{
  function _slugify(string $string): string
  {
    $str = $string; // for comparisons
    $str = $this->_toUtf8($str); // Force to work with string in UTF-8
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

    if ($str != htmlentities($string, ENT_QUOTES, 'UTF-8')) { // iconv fails
      $str = $this->_toUtf8($string);
      $str = htmlentities($str, ENT_QUOTES, 'UTF-8');
      $str = preg_replace('#&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);#i', '$1', $str);
      // Need to strip non ASCII chars or any other than a-z, A-Z, 0-9...
      $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
      $str = preg_replace(array('#[^0-9a-z]#i', '#[ -]+#'), ' ', $str);
      $str = trim($str, ' -');
    }

    // lowercase
    $string = strtolower($str);

    return $string;
  }

  function _toUtf8(string $str_in): ?string
  {
    if (!function_exists('mb_detect_encoding')) {
      throw new \Exception('The Multi Byte String extension is absent!');
    }
    $str_out = [];
    $words = explode(" ", $str_in);
    foreach ($words as $word) {
      $current_encoding = mb_detect_encoding($word, 'UTF-8, ASCII, ISO-8859-1');
      $str_out[] = mb_convert_encoding($word, 'UTF-8', $current_encoding);
    }
    return implode(" ", $str_out);
  }
}
