<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 * @author Omar Makled <omar.makled@gmail.com>
 */
class ApiControllerTest extends WebTestCase
{
  public function testGetCountOnSuccess(): void
  {
    $client = static::createClient();
    $client->request('GET', '/count');
    $content = json_decode($client->getResponse()->getContent(), true);

    $this->assertResponseIsSuccessful();
    $this->assertArrayHasKey('counter', $content);
  }

  public function testGetCountBadInputParameter(): void
  {
    $client = static::createClient();
    $client->request('GET', '/count?foo');
    $content = json_decode($client->getResponse()->getContent(), true);

    $this->assertResponseStatusCodeSame(400);
    $this->assertEquals($content, 'bad input parameter');
  }
}
