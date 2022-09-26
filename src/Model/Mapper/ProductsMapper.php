<?php
declare(strict_types=1);

namespace App\Model\Mapper;

use App\Entity\Product;
use App\Model\Dto\ProductDataTransferObject;

class ProductsMapper
{
    public function __construct(private CategoriesMapper $catMapper)
    {
    }

    public function mapToDto(array $product): ProductDataTransferObject
    {
        $product = $this->validate($product);

        return new ProductDataTransferObject(
            $product['id'],
            $product['name'],
            $product['size'],
            $product['color'],
            $product['category'],
            $product['price'],
            $product['stock'],
            $product['active'],
        );
    }

    public function mapEntityToDto(Product $product): ProductDataTransferObject
    {
        $category = $this->catMapper->mapEntityToDto($product->category);

        return new ProductDataTransferObject(
            $product->id,
            $product->name,
            $product->size,
            $product->color,
            $category,
            $product->price,
            $product->stock,
            $product->active,
        );
    }

    private function validate(array $product): array
    {
            $product['id'] = (int)$product['id'];
            $product['price'] = (float)$product['price'];
            $product['stock'] = (int)$product['stock'];
            $product['active'] = (bool)$product['active'];

        return $product;
    }
}