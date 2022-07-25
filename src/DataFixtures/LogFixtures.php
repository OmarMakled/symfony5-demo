<?php

namespace App\DataFixtures;

use App\Service\LogParser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogFixtures extends Fixture
{
  /**
   * List of dump data
   * 
   * @var array
   */
  private $logs = [
    'USER-SERVICE - - [17/Aug/2021:09:21:53 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:21:54 +0000] "POST /users HTTP/1.1" 400',
    'INVOICE-SERVICE - - [17/Aug/2021:09:21:55 +0000] "POST /invoices HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:21:56 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:21:57 +0000] "POST /users HTTP/1.1" 201',
    'INVOICE-SERVICE - - [17/Aug/2021:09:22:58 +0000] "POST /invoices HTTP/1.1" 201',
    'INVOICE-SERVICE - - [17/Aug/2021:09:22:59 +0000] "POST /invoices HTTP/1.1" 400',
    'INVOICE-SERVICE - - [17/Aug/2021:09:23:53 +0000] "POST /invoices HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:23:54 +0000] "POST /users HTTP/1.1" 400',
    'USER-SERVICE - - [17/Aug/2021:09:23:55 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:26:51 +0000] "POST /users HTTP/1.1" 201',
    'INVOICE-SERVICE - - [17/Aug/2021:09:26:53 +0000] "POST /invoices HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:29:11 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [17/Aug/2021:09:29:13 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [18/Aug/2021:09:30:54 +0000] "POST /users HTTP/1.1" 400',
    'USER-SERVICE - - [18/Aug/2021:09:31:55 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [18/Aug/2021:09:31:56 +0000] "POST /users HTTP/1.1" 201',
    'INVOICE-SERVICE - - [18/Aug/2021:10:26:53 +0000] "POST /invoices HTTP/1.1" 201',
    'USER-SERVICE - - [18/Aug/2021:10:32:56 +0000] "POST /users HTTP/1.1" 201',
    'USER-SERVICE - - [18/Aug/2021:10:33:59 +0000] "POST /users HTTP/1.1" 201',
  ];

  /**
   * @inheritDoc
   */
  public function load(ObjectManager $manager): void
  {
    $parser = new LogParser;

    foreach ($this->logs as $row) {
      $manager->persist($parser->fill($row));
    }

    $manager->flush();
  }
}