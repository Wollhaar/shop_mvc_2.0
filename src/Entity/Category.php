<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue)
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
     * @var bool
     * @ORM\Column(type="boolean")
     */
    public $active;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category_id")
     * @var Product[] An ArrayCollection of Product objects.
     */
    public $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function assignedProducts(Product $product): void
    {
        $this->products[] = $product;
    }
}