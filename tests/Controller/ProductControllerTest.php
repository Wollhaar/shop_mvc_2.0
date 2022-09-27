<?php
declare(strict_types=1);

namespace AppTest\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testList()
    {
        $crawler = $this->client->request(
            'GET',
            '/backend/product/list'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');

        $makeList = $crawler->filter('ul.backend-list a');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('Kategorieliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/category/list', $categoryInfo->attributes->item(0)->nodeValue);

        $productInfo = $makeList->getNode(1);
        self::assertSame('Produktliste', $productInfo->nodeValue);
        self::assertSame('/backend/product/list', $productInfo->attributes->item(0)->nodeValue);

        $makeList = $crawler->filter('ul.product-list li');
        self::assertCount(8, $makeList);
    }

    public function testShow()
    {
        $crawler = $this->client->request(
            'GET',
            '/backend/product/show/1'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');
        self::assertSelectorTextContains('h2', 'shirt no.1');


        $makeList = $crawler->filter('table.product-information tr');

        $size = $makeList->getNode(0);
        self::assertSame('M,L', $size->childNodes->item(1)->nodeValue);

        $color = $makeList->getNode(1);
        self::assertSame('weiss,schwarz', $color->childNodes->item(1)->nodeValue);

        $categoryName = $makeList->getNode(2);
        self::assertSame('T-Shirt', $categoryName->childNodes->item(1)->nodeValue);

        $price = $makeList->getNode(3);
        self::assertSame('21.89', $price->childNodes->item(1)->nodeValue);

        $stock = $makeList->getNode(4);
        self::assertSame('100', $stock->childNodes->item(1)->nodeValue);
    }

    public function testCreate()
    {
        $stamp = date('h_i');
        $crawler = $this->client->request(
            'POST',
            '/backend/product/create', [
                'name' => 'Testprodukt_' . $stamp,
                'size' => 'M,L,XL',
                'color' => 'black,white',
                'category' => '3',
                'price' => 11.31,
                'stock' => 200,
            ]
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');
        self::assertSelectorTextContains('h2', 'Product created');


        $makeList = $crawler->filter('.product-information tr');

        $name = $makeList->getNode(0)->childNodes->item(1);
        self::assertSame('Testprodukt_' . $stamp, $name->nodeValue);

        $size = $makeList->getNode(1)->childNodes->item(1);
        self::assertSame('M,L,XL', $size->nodeValue);

        $color = $makeList->getNode(2)->childNodes->item(1);
        self::assertSame('black,white', $color->nodeValue);

        $categoryName = $makeList->getNode(3)->childNodes->item(1);
        self::assertSame('Hosen', $categoryName->nodeValue);

        $price = $makeList->getNode(4)->childNodes->item(1);
        self::assertSame('11.31', $price->nodeValue);

        $stock = $makeList->getNode(5)->childNodes->item(1);
        self::assertSame('200', $stock->nodeValue);
    }
}