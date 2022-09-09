<?php
declare(strict_types=1);

namespace App\Model\EntityManager;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class EntityManager
{
    public static \Doctrine\ORM\EntityManager $entityManager;

    public static function setManager(\Doctrine\ORM\EntityManager $entityManager): void
    {
        self::$entityManager = $entityManager;
    }

    public static function getManager(): \Doctrine\ORM\EntityManager
    {
        return self::$entityManager;
    }
}