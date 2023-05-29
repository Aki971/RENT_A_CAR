<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Collection\Users;
use App\DTO\RequestParams\UserParams;
use App\DTO\RequestParams\UserByEmailParams;
use App\DTO\RequestParams\LoginUserParams;
use App\DTO\User as UserDTO;
use App\Entity\User;
use App\Exception\NotFound\UserNotFoundException;
use App\Exception\Exists\Exists;

use App\Query\UserInterface;
use App\Repository\UserRepository;
use App\Enum\Role;
use DateTime;
use Ramsey\Uuid\Nonstandard\Uuid;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserInterface $userQuery,
    ) {
    }

    public function getAll(): Users
    {
        return $this->userQuery->getAll();
    }

    public function get(string $guid): UserDTO
    {
        $user = $this->userQuery->getByGuid($guid);

        if (null === $user) {
            throw new UserNotFoundException($guid);
        }

        return $user;
    }

    public function login(LoginUserParams $params): User
    {
        $user = $this->userRepository->findOneBy([
            'email' => $params->email,
            'password' => $params->password,
        ]);

        if (null === $user) {
            throw new UserNotFoundException('User not found with that email and password.');
        }

        return $user;
    }

    public function create(UserParams $params): string
    {
        $emailCheck = $this->userRepository->findOneBy([
            'email' => $params->email
        ]);

        if (null !== $emailCheck) {
            throw new Exists('email','user',$params->email);
        }

        $user = $this->userRepository->getEntityInstance();
        $user->update($params);
        $this->userRepository->save($user);

        return $user->getGuid();
    }

    public function updateByGuid(string $guid, UserParams $params): void
    {
        $user = $this->findUser($guid);
        $user->update($params);

        $this->userRepository->save($user);
    }

    public function deleteByGuid(string $guid): void
    {
        $user = $this->findUser($guid);

        $this->userRepository->remove($user);
    }

    private function findUser(string $guid): User
    {
        $user = $this->userRepository->find($guid);

        if (null === $user) {
            throw new UserNotFoundException($guid);
        }

        return $user;
    }

    public function getByEmail(UserByEmailParams $params): UserDTO
    {
        $user = $this->userQuery->getByEmail($params->email);

        if (null === $user) {
            throw new UserNotFoundException($params->email);
        }

        return $user;
    }
}
