<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntegerConversion extends Model implements IntegerConversionInterface
{
  /**
   * Convert whole integer to roman numberals
   *
   *
   */
  public function toRomanNumerals($integer) {
    $numbers = str_split($integer);
    $length = count($numbers) ;
    $romanNumeral = '';
    foreach ($numbers as $key => $number) {
      if ($number == 4) {
        $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1)) . self::romanNumeralMapping(10 ** ($length-$key-1) * 5);
      } else if ($number == 9) {
        $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1)) . self::romanNumeralMapping(10 ** ($length-$key-1) * 10);
      } else if ($number > 5) {
        $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1) * 5);
        for ($i=0;$i<($number-5);$i++) {
          $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1));
        }
      } else if ($number < 5 && $number != 0) {
        for ($i=0;$i<$number;$i++) {
          $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1));
        }
      } else if ($number != 0){
        $romanNumeral .= self::romanNumeralMapping(10 ** ($length-$key-1) * 5);
      }
    }
    
    $this->integer = $integer;
    $this->romanNumeral = $romanNumeral;

    return $romanNumeral;
  }

  /**
   * Convert one single integer to roman numberal
   *
   * @return RomanNumeral
   */
  private static function romanNumeralMapping ($integer) {
    switch ($integer) {
      case 1:
          return 'I';
      case 5:
          return 'V';
      case 10:
          return 'X';
      case 50:
          return 'L';
      case 100:
          return 'C';
      case 500:
          return 'D';
      case 1000:
          return 'M';
    }
  }
}
