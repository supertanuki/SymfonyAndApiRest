<?php

namespace Acme\MyApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/articles');

        $this->assertTrue($crawler->filter('html:contains("List of articles")')->count() > 0);
    }
}
