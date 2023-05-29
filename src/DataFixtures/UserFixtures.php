<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_NAMES = ["Aleksa", "Nemanja", "Jovan", "Anja", "Danica"];
    private const USER_LAST_NAMES = ["Palibrk", "Petkovic", "Jovanovic", "Milutinovic", "Petrovic"];
    private const USER_ROLES = [Role::ADMIN, ROLE::PUBLIC];

    public function load(ObjectManager $manager): void
    {
        $usersManager = $this->createUser(0);
        $manager->persist($usersManager);
        $manager->flush();

        for ($i = 1; $i < count(self::USER_NAMES); $i++) {
            $user = $this->createUser($i);
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function createUser(int $index): User
    {
        $user = new User();
        $user->setName(self::USER_NAMES[$index])
             ->setLastName(self::USER_LAST_NAMES[$index])
             ->setEmail(strtolower($user->getName()[0] . $user->getLastName()) . $index . "@gmail.com")
             ->setRole(self::USER_ROLES[rand(0, count(self::USER_ROLES) - 1)])
             ->setPassword(self::USER_NAMES[$index] . "123")
             ->setImage('https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png');

        return $user;
    }

}