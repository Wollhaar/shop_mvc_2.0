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
        $category = $this->catMapper->mapToDto($product['category']);

        return new ProductDataTransferObject(
            $product['id'],
            $product['name'],
            $product['size'],
            $product['color'],
            $category,
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
}