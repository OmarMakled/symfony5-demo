<?php

namespace Tests\Unit\Service;

use App\Service\LogReader;
use InvalidArgumentException;
use LimitIterator;
use PHPUnit\Framework\TestCase;

/**
 * @group units
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogReaderTest extends TestCase
{
  private static $testFile = __DIR__ . '/log.txt';
  private static $dumpData = [
    "foo\n", "bar\n", "baz\n",
  ];

  public static function setUpBeforeClass(): void
  {
    $fh = fopen(self::$testFile, 'w');
    foreach (self::$dumpData as $line) {
      fwrite($fh, $line);
    }
    fclose($fh);
  }

  public static function tearDownAfterClass(): void
  {
    unlink(self::$testFile);
  }

  public function testOpenWrongFile(): void
  {
    $reader = new LogReader();
    $testFile = __dir__ . '/foo.txt';
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Can not open the file ' . $testFile);
    $reader->open($testFile);
  }

  public function testOpenAndRead(): void
  {
    $reader = new LogReader();
    foreach ($reader->open(self::$testFile) as $key => $line) {
      $this->assertEquals($line, self::$dumpData[$key]);
    };
  }

  public function testOpenAndReadOffset(): void
  {
    $reader = new LogReader();
    $lines = new LimitIterator($reader->open(self::$testFile), 2);
    foreach ($lines as $key => $line) {
      $this->assertEquals($line, self::$dumpData[$key]);
    }
  }
}
