<?php
declare(strict_types=1);

namespace App\Model\Dto;

class ProductDataTransferObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $size,
        public readonly string $color,
        public readonly string $category,
        public readonly float $price,
        public readonly int $stock,
        public readonly bool $active,
    )
    {}
}