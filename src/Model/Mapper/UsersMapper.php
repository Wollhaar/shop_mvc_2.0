<?php
declare(strict_types=1);

namespace App\Model\Mapper;

use App\Entity\User;
use App\Model\Dto\UserDataTransferObject;

class UsersMapper
{
    public function mapToDto(array $user): UserDataTransferObject
    {
        return new UserDataTransferObject(
            $user['id'],
            $user['username'],
            $user['password'],
            $user['email'],
            $user['firstname'],
            $user['lastname'],
            $user['birthday'],
            $user['created'],
            $user['updated'],
            $user['role'],
            $user['active'],
        );
    }

    public function mapEntityToDto(User $user): UserDataTransferObject
    {
        return new UserDataTransferObject(
            $user->id,
            $user->username,
            $user->password,
            $user->email,
            $user->firstname,
            $user->lastname,
            $user->birthday,
            $user->created,
            $user->updated,
            $user->role,
            $user->active,
        );
    }
}