<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\HasGuidTrait;
use App\Entity\Trait\TimestampableTrait;
use JsonSerializable;
use App\DTO\RequestParams\VehicleParams;


#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\Table(name: 'vehicles')]
#[ORM\HasLifecycleCallbacks]
class Vehicle implements JsonSerializable, BaseEntityInterface
{
    use HasGuidTrait;
    use TimestampableTrait;

    #[ORM\Column(length: 255)]
    private string $make;

    #[ORM\Column(length: 255)]
    private string $model;

    #[ORM\Column]
    private int $price;

    #[ORM\Column(length: 255)]
    private string $description;

    #[ORM\Column(length: 255)]
    private string $image;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function setMake(string $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
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
            'make' => $this->make,
            'model' => $this->model,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }

    public function update(VehicleParams $params): void
    {
        $this->make = $params->make;
        $this->model = $params->model;
        $this->price = $params->price;
        $this->description = $params->description;
        $this->image = $params->image;
    }
}
