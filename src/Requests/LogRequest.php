<?php
namespace App\Requests;
use App\Validator as Assert;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogRequest extends BaseRequest
{
  #[Assert\StringOrArray]
  protected $serviceNames;

  #[Assert\Integer]
  protected $statusCode;

  #[Assert\DateTime]
  protected $startDate;

  #[Assert\DateTime]
  protected $endDate;

  /**
   * @inheritDoc
   */
  public function getData(): array
  {
    return [
      'serviceNames' => $this->serviceNames,
      'startDate' => $this->startDate,
      'endDate' => $this->endDate,
      'statusCode' => $this->statusCode,
    ];
  }
}
