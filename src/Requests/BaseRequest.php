<?php

namespace App\Requests;

use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
abstract class BaseRequest
{
  /**
   * @var ValidatorInterface
   */
  protected $validator;

  /**
   *
   * @param ValidatorInterface $validator
   */
  public function __construct(ValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  /**
   * Checks if the data is valid
   *
   * @param array $data
   * @return boolean
   * @throws InvalidArgumentException
   */
  public function isValid(array $data): bool
  {
    try {
      $errors = $this->validator->validate($this->populate($data));

      return count($errors) === 0 ? true : false;
    } catch (InvalidArgumentException $e) {
      return false;
    }
  }

  /**
   * Fill from given data
   *
   * @param array $data
   * @return self
   * @throws InvalidArgumentException
   */
  public function populate(array $data): self
  {
    foreach ($data as $property => $value) {
      if (!property_exists($this, $property)) {
        throw new InvalidArgumentException;
      }

      $this->{$property} = $value;
    }

    return $this;
  }

  /**
   * Get data
   *
   * @return array
   */
  abstract public function getData(): array;
}
