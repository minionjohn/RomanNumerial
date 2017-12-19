<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\toRomanNumerals;
use App\IntegerConversion;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\IntegerConversionTransformer;

class IntegerConversionController extends Controller
{
    /**
     * Convert integer to roman numerals
     *
     *
     */
    public function integerConvert($integer)
    {
      if (!is_numeric($integer)) {
        throw new \Exception('Alphabet doesn\'t accept. Only accept Integer');
      }

      if ((int) $integer != $integer) {
        throw new \Exception('Floating-point doesn\'t accept. Please enter integer');
      }

      if ((int) $integer > 3999) {
        throw new \Exception('Only support integers ranging from 1 to 3999');
      }

      $romanNumeral = new IntegerConversion;
      $romanNumeral->toRomanNumerals($integer);
      $romanNumeral->save();

      $fractal = new Manager();
      $resource = new Item($romanNumeral, new IntegerConversionTransformer());
      echo $fractal->createData($resource)->toJson();
    }

    /**
     * Lists all of the recently converted integers
     *
     *
     */
    public function integers()
    {
      $romanNumerals = IntegerConversion::orderBy('id', 'desc')->get();
      $fractal = new Manager();
      $resource = new Collection($romanNumerals, new IntegerConversionTransformer());

      echo $fractal->createData($resource)->toJson();
    }

    /**
     * Lists the top 10 converted integers
     *
     * 
     */
    public function topIntegers()
    {
      $romanNumerals = IntegerConversion::groupBy('integer_conversions.integer')
      ->orderBy('count', 'desc')
      ->take(10)
      ->get(['integer_conversions.integer', DB::raw('count(integer_conversions.integer) as count')]);

      $fractal = new Manager();
      $resource = new Collection($romanNumerals, new IntegerConversionTransformer());

      echo $fractal->createData($resource)->toJson();
    }
}
