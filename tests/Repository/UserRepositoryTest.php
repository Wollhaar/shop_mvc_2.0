<?php
declare(strict_types=1);

namespace AppTest\Repository;

use App\Model\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->usrRepo = self::getContainer()->get(UserRepository::class);
    }

    public function testFindUserById()
    {
        $user = $this->usrRepo->findById(2);

        self::assertSame(2, $user->id);
        self::assertSame('Chuck', $user->firstname);
        self::assertSame('Test', $user->firstname);
    }

    public function testGetAll()
    {
        $userList = $this->usrRepo->getAll();

        $user1 = $userList[0];
        self::assertSame(1, $user1->id);
        self::assertSame('dave', $user1->username);
        self::assertSame('David', $user1->firstname);
        self::assertTrue($user1->active);

        $user2 = $userList[1];
        self::assertSame(2, $user2->id);
        self::assertSame('test', $user2->username);
        self::assertSame('Chuck', $user2->firstname);
        self::assertTrue($user2->active);

        $user3 = $userList[2];
        self::assertSame(3, $user3->id);
        self::assertSame('maxi', $user3->username);
        self::assertSame('rest', $user3->firstname);
        self::assertTrue($user3->active);
    }
}