<?php
namespace App\Transformers;

use App\Role;
use League\Fractal\TransformerAbstract;
use App\IntegerConversion;

class IntegerConversionTransformer extends TransformerAbstract
{
  /**
   * Transformer the IntegerConversion to array json output
   *
   * @return Array
   */
    public function transform(IntegerConversion $integer)
    {
      if ($integer->romanNumeral) {
        return [
            'integer' => $integer->integer,
            'romanNumeral' => $integer->romanNumeral
        ];
      } else {
        return [
            'integer' => $integer->integer
        ];
      }
    }
}
