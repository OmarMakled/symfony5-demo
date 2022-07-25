<?php

namespace App\Service;

use App\Entity\Log;
use DateTime;
use InvalidArgumentException;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogParser
{
  /**
   * @see https://regex101.com/r/FuM7TM/1
   */
  const REGX_SERVICE = '/.+?SERVICE/';

  /**
   * @see https://regex101.com/r/Y154rT/1
   */
  const REGX_DATE = '/\[(.+)]/';

  /**
   * @see https://regex101.com/r/dKvKmd/1
   */
  const REGX_REQUEST = '/".+/';

  /**
   *
   * @var array
   */
  private $cast = [
    'service',
    'date',
    'request',
  ];

  /**
   * Get service
   *
   * @param  string $line
   * @return string
   * @throws InvalidArgumentException
   */
  public function getService(string $line): string
  {
    if (preg_match(self::REGX_SERVICE, $line, $matches)) {
      return $matches[0];
    }

    throw new InvalidArgumentException('Can not parse service');
  }

  /**
   * Get datetime
   *
   * @param  string $line
   * @return string
   * @throws InvalidArgumentException
   */
  public function getDate(string $line): string
  {
    if (preg_match(self::REGX_DATE, $line, $matches)) {
      return $matches[1];
    }

    throw new InvalidArgumentException('Can not parse date');
  }

  /**
   * Get request
   *
   * @param  string $line
   * @return string
   * @throws InvalidArgumentException
   */
  public function getRequest(string $line): string
  {
    if (preg_match(self::REGX_REQUEST, $line, $matches)) {
      return $matches[0];
    }

    throw new InvalidArgumentException('Can not parse request');
  }

  /**
   *
   * @param  string $line
   * @return array
   * @throws InvalidArgumentException
   */
  public function parse(string $line)
  {
    $data = [];
    foreach ($this->cast as $val) {
      $fn = 'get' . ucwords($val);
      if (method_exists($this, $fn)) {
        $data[$val] = $this->$fn($line);
      }
    }
    return $data;
  }

  /**
   * Fill log entity
   *
   * @param string $line
   * @return Log
   */
  public function fill(string $line): Log
  {
    $log = new Log;
    $data = $this->parse($line);
    $log->setService($data['service']);
    $log->setDate((new DateTime)->setTimestamp(strtotime($data['date'])));
    $log->setRequest($data['request']);

    return $log;
  }
}
