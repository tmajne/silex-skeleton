<?php

declare(strict_types=1);

namespace App\Test;

class ExampleTest extends AppTestCase
{
    public function testInitialPage()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());

        // we also can check that page contains some elemnts
        //$this->assertCount(1, $crawler->filter('h1:contains("Contact us")'));
        //$this->assertCount(1, $crawler->filter('form'));
    }
}
