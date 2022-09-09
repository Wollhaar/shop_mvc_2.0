<?php
declare(strict_types=1);

// list_products.php
use App\Model\Entity\Product;

require_once __DIR__ . "/../bootstrap-doctrine.php";

$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->name . ', ' . $product->size . ', ' . $product->color . ', ' . $product->category . ', ' . $product->price . ', ' . $product->stock . ', ');
}