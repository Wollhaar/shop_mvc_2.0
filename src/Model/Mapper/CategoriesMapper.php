<?php
declare(strict_types=1);

namespace App\Model\Mapper;

use App\Entity\Category;
use App\Model\Dto\CategoryDataTransferObject;

class CategoriesMapper
{
    public function mapToDto(array $category): CategoryDataTransferObject
    {
        return new CategoryDataTransferObject(
            $category['id'],
            $category['name'],
            $category['active'],
        );
    }

    public function mapEntityToDto(Category $category): CategoryDataTransferObject
    {
        return new CategoryDataTransferObject(
            $category->id,
            $category->name,
            $category->active,
        );
    }
}