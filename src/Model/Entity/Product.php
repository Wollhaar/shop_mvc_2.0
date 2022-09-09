<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    public $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    public $size;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    public $color;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    public $category;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    public $price;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    public $stock;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    public $active;

    public function setCategory(Category $category): void
    {
        $category->assignedProducts($this);
        $this->category = $category;
    }
}