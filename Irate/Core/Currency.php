<?php

namespace Irate\Core;

/**
 * Currency Class
 */
class Currency
{

  public static function toPennies ($value) {
    return preg_replace("/[^0-9.]/", "", $value) * 100;
  }

  public static function toDollars ($value) {
    return number_format(($value / 100), 2, '.', '');
  }
}
