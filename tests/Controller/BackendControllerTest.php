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

        $tag = $crawler->filter('h1');
        self::assertSame('BackendBoard', $tag->getNode(0)->nodeValue);

        $makeList = $crawler->filter('ul.backend-list a');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('Kategorieliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/category/list', $categoryInfo->attributes->item(0)->nodeValue);

        $categoryInfo = $makeList->getNode(1);
        self::assertSame('Produktliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/product/list', $categoryInfo->attributes->item(0)->nodeValue);
    }
}