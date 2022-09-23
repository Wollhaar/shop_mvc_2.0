<?php
declare(strict_types=1);

namespace AppTest\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
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
            '/backend/category/list'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');

        $makeList = $crawler->filter('ul.category-list a');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('Kategorieliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/category/list', $categoryInfo->attributes->item(0)->nodeValue);
    }

    public function testOne()
    {
        $crawler = $this->client->request(
            'GET',
            '/backend/category/list/1'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'BackendBoard');

        $makeList = $crawler->filter('ul.category-list a');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('Kategorieliste', $categoryInfo->nodeValue);
        self::assertSame('/backend/category/list', $categoryInfo->attributes->item(0)->nodeValue);


        $makeList = $crawler->filter('.category-selection');

        $categoryInfo = $makeList->getNode(0);
        self::assertSame('T-Shirt', trim($categoryInfo->nodeValue));
    }
//
//    public function testCreate()
//    {
//        $crawler = $this->client->request(
//            'POST',
//            '/backend/category/create',
//            ['name' => 'TestCategory']
//        );
//        self::assertResponseStatusCodeSame(200);
//
//        $creationField = $crawler->filter('.category-creation');
//
//        $categoryLabel = $creationField->children('label')->getNode(0);
//        $categoryName = $creationField->children('p')->getNode(0);
//        self::assertSame('Created Category', $categoryLabel->nodeValue);
//        self::assertSame('TestCategory', $categoryName->nodeValue);
//    }
}