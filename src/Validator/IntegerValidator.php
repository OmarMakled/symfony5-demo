<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class IntegerValidator extends ConstraintValidator
{
  /**
   * @inheritDoc
   */
  public function validate($value, Constraint $constraint)
  {
    if ($value === null) {
      return;
    }

    if (is_array($value)) {
      $this->context->buildViolation($constraint->message)->addViolation();

      return;
    }

    if (!preg_match('/^[0-9]+$/', $value)) {
      $this->context->buildViolation($constraint->message)
        ->setParameter('{{ value }}', $value)
        ->addViolation();
    }
  }
}
