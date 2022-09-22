<?php
declare(strict_types=1);

namespace AppTest\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class BackendControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testBoard()
    {
        $crawler = $this->client->request(
            'GET',
            '/backend'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');

        $makeList = $crawler->filter('ul.category-list a');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('Kategorieliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/category/list', $categoryInfo->attributes->item(1)->nodeValue);
    }
}