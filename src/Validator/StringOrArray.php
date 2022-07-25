<?php
namespace App\Validator;

use App\Validator\StringOrArrayValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class StringOrArray extends Constraint
{
  public $message = 'The value "{{ value }}" is invalid. allows string or array of string';

  /**
   * @inheritDoc
   */
  public function validatedBy(): string
  {
    return StringOrArrayValidator::class;
  }
}
