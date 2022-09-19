<?php
declare(strict_types=1);

namespace App\Model\Mapper;

use App\Entity\Product;
use App\Model\Dto\ProductDataTransferObject;

class ProductsMapper
{
    public function mapToDto(array $product): ProductDataTransferObject
    {
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
        return new ProductDataTransferObject(
            $product->id,
            $product->name,
            $product->size,
            $product->color,
            $product->category->name,
            $product->price,
            $product->stock,
            $product->active,
        );
    }
}