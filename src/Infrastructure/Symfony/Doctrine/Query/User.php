<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Users;
use App\DTO\User as UserDTO;
use App\Enum\Role;
use App\Query\UserInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class User implements UserInterface
{
    private const SELECT_QUERY = [
        'u.guid as user_guid',
        'u.name as user_name',
        'u.last_name as user_last_name',
        'u.email as user_email',
        'u.password as user_password',
        'u.role as user_role',
        'u.image as user_image',
        'u.created_at as user_created_at',
        'u.updated_at as user_updated_at',
    ];

    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): Users
    {
        $usersData = $this->connection->createQueryBuilder('users')
            ->select(self::SELECT_QUERY)
            ->from('users', 'u')
            ->orderBy('u.name', 'ASC')
            ->fetchAllAssociative();

        return new Users(array_map(fn(array $userData) => $this->createUserDTO($userData), $usersData));
    }

    public function getByGuid(string $guid): ?UserDTO
    {
        $userData = $this->connection->createQueryBuilder()
            ->select(self::SELECT_QUERY)
            ->from('users', 'u')
            ->where('u.guid = :guid')
            ->setParameter('guid', $guid)
            ->fetchAssociative();

        if (false === $userData) {
            return null;
        }

        return $this->createUserDTO($userData);
    }

    public function getByEmail(string $email): ?UserDTO
    {
        $userData = $this->connection->createQueryBuilder()
            ->select(self::SELECT_QUERY)
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->fetchAssociative();

        if (false === $userData) {
            return null;
        }

        return $this->createUserDTO($userData);
    }

    public function getAllEmails(): array
    {
        $usersDataEmails = $this->connection->createQueryBuilder('users')
            ->select('email')
            ->from('users')
            ->fetchAllAssociative();

        return $usersDataEmails;
    }

    private function createUserDTO(array $userData): UserDTO
    {
        return new UserDTO(
            $userData['user_guid'],
            $userData['user_name'],
            $userData['user_last_name'],
            $userData['user_email'],
            $userData['user_password'],
            Role::from($userData['user_role']),
            $userData['user_image'],
            new DateTimeImmutable($userData['user_created_at']),
            $userData['user_updated_at'] ? new DateTime($userData['user_updated_at']) : null,
        );
    }
}
