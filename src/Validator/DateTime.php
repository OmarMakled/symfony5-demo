<?php
namespace App\Validator;

use App\Validator\DateTimeValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DateTime extends Constraint
{
    public $message = 'The value "{{ value }}" is invalid datetime';

    /**
     * @inheritDoc
     */
    public function validatedBy() :string
    {
        return DateTimeValidator::class;
    }
}