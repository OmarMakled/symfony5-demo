<?php
namespace App\Validator;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class DateTimeValidator extends ConstraintValidator
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

    $date = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    if ($date === false || array_sum($date::getLastErrors())) {
      $this->context->buildViolation($constraint->message)
        ->setParameter('{{ value }}', $value)
        ->addViolation();
    }
  }
}
