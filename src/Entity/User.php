<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\DTO\RequestParams\UserParams;
use App\Enum\Role;
use App\Entity\Trait\HasGuidTrait;
use App\Entity\Trait\TimestampableTrait;
use JsonSerializable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements JsonSerializable, BaseEntityInterface
{
    use HasGuidTrait;
    use TimestampableTrait;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 100)]
    private string $lastName ;

    #[ORM\Column(length: 200, unique: true)]
    private string $email;

    #[ORM\Column(length: 200)]
    private string $password;

    #[ORM\Column(type: 'string', enumType: Role::class)]
    private Role $role;

    #[ORM\Column(length: 255, nullable: true)]
    private string $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'name' => $this->name,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }

    public function update(UserParams $params): void
    {
        $this->name = $params->name;
        $this->lastName = $params->lastName;
        $this->email = $params->email;
        $this->password = $params->password;
        $this->role = $params->role;
        $this->image = $params->image;
    }
}
