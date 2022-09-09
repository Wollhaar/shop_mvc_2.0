<?php declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$id = $argv[1];
$attr = $argv[2];
$val = $argv[3];


$product = $entityManager->find(\App\Model\Entity\Product::class, $id);

switch ($attr) {
    case 'name':
        $product->setName($val);
        break;
    case 'size':
        $product->setSize($val);
        break;
    case 'color':
        $product->setColor($val);
        break;
    case 'category':
        $category = $entityManager->find(\App\Model\Entity\Category::class, (int)$val);
        $product->setCategory($category);
        break;
    case 'price':
        $product->setPrice($val);
        break;
    case 'amount':
        $product->setAmount((int)$val);
        break;
    case 'active':
        $product->setActive((bool)$val);
        break;
}
$entityManager->flush();
