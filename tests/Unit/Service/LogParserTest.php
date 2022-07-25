<?php

namespace Tests\Unit\Service;

use DateTimeInterface;
use App\Service\LogParser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @group units
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogParserTest extends TestCase
{
  public function testGetService(): void
  {
    $parser = new LogParser();
    $this->assertEquals($parser->getService('FOO-SERVICE dump'), 'FOO-SERVICE');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Can not parse service');
    $parser->getService('FOO-BAR dump');
  }

  public function testGetDate(): void
  {
    $parser = new LogParser();
    $this->assertEquals($parser->getDate('FOO-SERVICE [17/Aug/2021:09:21:53 +0000] dump'), '17/Aug/2021:09:21:53 +0000');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Can not parse date');
    $parser->getDate('FOO-BAR dump');
  }

  public function testGetRequest(): void
  {
    $parser = new LogParser();
    $this->assertEquals($parser->getRequest('FOO-SERVICE [17/Aug/2021:09:21:53 +0000] "POST /foo HTTP/1.1" 201'), '"POST /foo HTTP/1.1" 201');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Can not parse request');
    $parser->getRequest('FOO-BAR dump');
  }

  public function testParse(): void
  {
    $parser = new LogParser();
    $data = $parser->parse('FOO-SERVICE [17/Aug/2021:09:21:53 +0000] "POST /foo HTTP/1.1" 201');
    $this->assertEquals($data['service'], 'FOO-SERVICE');
    $this->assertEquals($data['date'], '17/Aug/2021:09:21:53 +0000');
    $this->assertEquals($data['request'], '"POST /foo HTTP/1.1" 201');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Can not parse date');
    $parser->parse('FOO-SERVICE dump');
  }

  public function testFill(): void
  {
    $parser = new LogParser();
    $entity = $parser->fill('FOO-SERVICE [17/Aug/2021:09:21:53 +0000] "POST /foo HTTP/1.1" 201');
    $this->assertEquals($entity->getService(), 'FOO-SERVICE');
    $this->assertInstanceOf(DateTimeInterface::class, $entity->getDate());
    $this->assertEquals($entity->getDate()->format('Y-m-d H:m:s'), '2021-08-17 09:08:53');
    $this->assertEquals($entity->getRequest(), '"POST /foo HTTP/1.1" 201');
  }
}
