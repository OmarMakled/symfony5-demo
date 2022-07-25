<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
abstract class BaseController
{
  /**
   *
   * @var Request
   */
  protected $request;

  /**
   *
   * @var array
   */
  protected $query;

  /**
   *
   * @param RequestStack $request
   * @param ValidatorInterface $validator
   */
  public function __construct(RequestStack $request, ValidatorInterface $validator)
  {
    $this->request = $request->getCurrentRequest();

    $this->query = $this->request->query->all();
  }
}
