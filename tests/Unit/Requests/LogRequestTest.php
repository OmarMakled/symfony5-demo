<?php

namespace Tests\Unit\Requests;

use App\Requests\LogRequest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group units
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogRequestTest extends WebTestCase
{
  private $logRequest;

  protected function setUp(): void
  {
    static::$kernel = static::createKernel();
    static::$kernel->boot();
    $container = static::$kernel->getContainer();

    $this->logRequest = new LogRequest($container->get('validator'));
  }

  public function testGetServiceNames(): void
  {
    $isValid = $this->logRequest->isValid(['serviceNames' => "foo,bar"]);
    $this->assertTrue($isValid);
    $isValid = $this->logRequest->isValid(['serviceNames' => ["foo", "bar"]]);
    $this->assertTrue($isValid);

    $isValid = $this->logRequest->isValid(['serviceNames' => "foo,22"]);
    $this->assertFalse($isValid);
  }

  public function testGetStatusCode(): void
  {
    $isValid = $this->logRequest->isValid(['statusCode' => 200]);
    $this->assertTrue($isValid);

    $isValid = $this->logRequest->isValid(['statusCode' => "foo"]);
    $this->assertFalse($isValid);
    $isValid = $this->logRequest->isValid(['statusCode' => [200, 201]]);
    $this->assertFalse($isValid);
  }

  public function testGetStartAndEndDate(): void
  {
    $isValid = $this->logRequest->isValid(['startDate' => "2021-08-17 09:21:55"]);
    $this->assertTrue($isValid);

    $isValid = $this->logRequest->isValid(['startDate' => "2021-08-32 09:21:55"]);
    $this->assertFalse($isValid);
    $isValid = $this->logRequest->isValid(['startDate' => ["2021-08-17 09:21:55"]]);
    $this->assertFalse($isValid);
  }
}
