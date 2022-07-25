<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 */
class HealthCheckControllerTest extends WebTestCase
{
    public function testHealthZEndpoint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/healthz');

        $this->assertResponseIsSuccessful();
    }
}
