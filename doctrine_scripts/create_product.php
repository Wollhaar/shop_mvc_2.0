<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$newProductName = $argv[1];
$newProductSize = $argv[2];
$newProductColor = $argv[3];
$newProductCategory = $argv[4];
$newProductPrice = $argv[5];
$newProductAmount = $argv[6];
$newProductActive = $argv[7];


$category = $entityManager->find(\App\Model\Entity\Category::class, (int)$newProductCategory);

$product = new \App\Model\Entity\Product();
$product->name = $newProductName;
$product->size = $newProductSize;
$product->color = $newProductColor;
$product->setCategory($category);
$product->price = (float)$newProductPrice;
$product->stock = (int)$newProductAmount;
$product->active = (bool)$newProductActive;

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->id . " and name: $newProductName and Category: " . $category->name . "\n";