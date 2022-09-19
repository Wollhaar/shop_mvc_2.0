<?php
declare(strict_types=1);

namespace App\Model\Dto;

class CategoryDataTransferObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly bool $active,
    )
    {}
}