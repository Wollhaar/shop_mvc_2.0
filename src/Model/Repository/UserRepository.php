<?php
declare(strict_types=1);

namespace App\Model\Repository;

use App\Entity\User;
use App\Model\Dto\UserDataTransferObject;
use App\Model\Mapper\UsersMapper;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UsersMapper $mapper
    )
    {}

    public function findById(int $id): UserDataTransferObject|null
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
                'active' => true,
            ]);
        return is_null($user) ? null : $this->mapper->mapEntityToDto($user);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(User::class)
            ->findBy([
                'active' => true
            ]);
    }
}