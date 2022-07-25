<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group functional
 * @author Omar Makled <omar.makled@gmail.com>
 */
class ImportLogsCommandTest extends WebTestCase
{
  private static $testFile = __DIR__ . '/log.txt';
  private static $dumpData = [
    'USER-SERVICE - - [17/Aug/2021:09:21:54 +0000] "POST /users HTTP/1.1" 400',
    'USER-SERVICE - - [17/Aug/2021:09:21:54 +0000] "POST /users HTTP/1.1" 400',
    'USER-SERVICE - - [17/Aug/2021:09:21:54 +0000] "POST /users HTTP/1.1" 400',
    'USER-SERVICE - - [17/Aug/2021:09:21:54 +0000] "POST /users HTTP/1.1" 400',
  ];
  private static $command;

  public static function setUpBeforeClass(): void
  {
    $kernel = self::bootKernel();
    $application = new Application($kernel);
    self::$command = new CommandTester($application->find('app:import'));

    $fh = fopen(self::$testFile, 'w');
    foreach (self::$dumpData as $line) {
      fwrite($fh, $line . PHP_EOL);
    }
    fclose($fh);
  }

  public static function tearDownAfterClass(): void
  {
    unlink(self::$testFile);
  }

  public function testImportAllLogs(): void
  {
    self::$command->execute([
      'file' => self::$testFile,
    ]);
    self::$command->assertCommandIsSuccessful();
    $output = self::$command->getDisplay();
    $this->assertStringContainsString('Inserted logs 4', $output);
  }

  public function testImportLogsFrom(): void
  {
    self::$command->execute([
      'file' => self::$testFile,
      'start' => 2,
    ]);
    self::$command->assertCommandIsSuccessful();
    $output = self::$command->getDisplay();
    $this->assertStringContainsString('Inserted logs 2', $output);
  }
}
