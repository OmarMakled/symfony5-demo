<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class StringOrArrayValidator extends ConstraintValidator
{
  /**
   * @inheritDoc
   */
  public function validate($value, Constraint $constraint)
  {
    if ($value === null) {
      return;
    }

    $array = is_array($value) ? $value : explode(',', $value);
    foreach ($array as $val) {
      if (!preg_match('/^[a-zA-Z]+$/', $val)) {
        $this->context->buildViolation($constraint->message)
          ->setParameter('{{ value }}', $value)
          ->addViolation();

        return;
      }
    }
  }
}
