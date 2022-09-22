<?php
declare(strict_types=1);

namespace AppTest\Controller;

use App\Controller\FrontendController;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Twig\Environment;

class FrontendControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testHome()
    {
        $crawler = $this->client->request(
            'GET',
            '/'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Shop');

        $makeList = $crawler->filter('ul.category-list a');

        $tShirtInfo = $makeList->getNode(0);
        self::assertSame('T-Shirt', $tShirtInfo->nodeValue);
        self::assertSame('/categories/1', $tShirtInfo->attributes->item(1)->nodeValue);

        $pulloverInfo = $makeList->getNode(1);
        self::assertSame('Pullover', $pulloverInfo->nodeValue);
        self::assertSame('/categories/2', $pulloverInfo->attributes->item(1)->nodeValue);

        $hosenInfo = $makeList->getNode(2);
        self::assertSame('Hosen', $hosenInfo->nodeValue);
        self::assertSame('/categories/3', $hosenInfo->attributes->item(1)->nodeValue);

        $sportswearInfo = $makeList->getNode(3);
        self::assertSame('Sportswear', $sportswearInfo->nodeValue);
        self::assertSame('/categories/4', $sportswearInfo->attributes->item(1)->nodeValue);

        $jackenInfo = $makeList->getNode(4);
        self::assertSame('Jacken', $jackenInfo->nodeValue);
        self::assertSame('/categories/5', $jackenInfo->attributes->item(1)->nodeValue);
    }

    public function testCategories()
    {
        $crawler = $this->client->request(
            'GET',
            '/categories/2'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h3', 'Pullover');


        $makeList = $crawler->filter('div.product-list > ul a');

        $pulli = $makeList->getNode(0);
        self::assertSame('Hoodie - Kapuzenpulli', $pulli->nodeValue);
    }

    public function testDetailed()
    {
        $crawler = $this->client->request(
            'GET',
            '/detail/2'
        );
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h2', 'HSV - Home-Jersey');


        $makeList = $crawler->filter('div.product-details > table > tr');

        $size = $makeList->getNode(0)->childNodes->item(1);
        self::assertSame('M,L', $size->nodeValue);

        $color = $makeList->getNode(1)->childNodes->item(1);
        self::assertSame('weiß', $color->nodeValue);

        $categoryName = $makeList->getNode(2)->childNodes->item(1);
        self::assertSame('Sportswear', $categoryName->nodeValue);

        $price = $makeList->getNode(3)->childNodes->item(1);
        self::assertSame('80.9', $price->nodeValue);

        $stock = $makeList->getNode(4)->childNodes->item(1);
        self::assertSame('200', $stock->nodeValue);
    }
}