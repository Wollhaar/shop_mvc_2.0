<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$newCategoryName = $argv[1];

$category = new \App\Model\Entity\Category();
$category->name = $newCategoryName;
$category->active = true;

$entityManager->persist($category);
$entityManager->flush();

echo "Created Product with ID " . $category->id . " and name: $newCategoryName\n";