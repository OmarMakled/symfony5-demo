<?php
namespace App\Validator;

use App\Validator\IntegerValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Integer extends Constraint
{
  public $message = 'The value "{{ value }}" is invalid integer.';

  /**
   * @inheritDoc
   */
  public function validatedBy(): string
  {
    return IntegerValidator::class;
  }
}
