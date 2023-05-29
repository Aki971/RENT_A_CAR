<?php

namespace App\Entity;

use App\Repository\BookingHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\HasGuidTrait;
use App\Entity\Trait\TimestampableTrait;
use App\DTO\RequestParams\BookingHistoryParams;
use JsonSerializable;

#[ORM\Entity(repositoryClass: BookingHistoryRepository::class)]
#[ORM\Table(name: 'booking_history')]
#[ORM\HasLifecycleCallbacks]
class BookingHistory implements BaseEntityInterface, JsonSerializable
{
    use HasGuidTrait;
    use TimestampableTrait;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'rented_by', referencedColumnName: 'guid', nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'vehicles', referencedColumnName: 'guid', nullable: false)]
    private Vehicle $vehicle;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $bookingStart;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $bookingEnd;

    #[ORM\Column(type: 'boolean')]
    private bool $approved;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getBookingStart(): \DateTimeInterface
    {
        return $this->bookingStart;
    }

    public function setBookingStart(\DateTimeInterface $bookingStart): self
    {
        $this->bookingStart = $bookingStart;

        return $this;
    }

    public function getBookingEnd(): \DateTimeInterface
    {
        return $this->bookingEnd;
    }

    public function setBookingEnd(\DateTimeInterface $bookingEnd): self
    {
        $this->bookingEnd = $bookingEnd;

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'user' => $this->user,
            'vehicle' => $this->vehicle,
            'bookingStart' => $this->bookingStart,
            'bookingEnd' => $this->bookingEnd,
            'approved' => $this->approved,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }

    public function update(BookingHistoryParams $params, User $user, Vehicle $vehicle): void
    {
        $this->user = $user;
        $this->vehicle = $vehicle;
        $this->bookingStart = new \DateTime($params->bookingStart);
        $this->bookingEnd = new \DateTime($params->bookingEnd);
        $this->approved = $params->approved;
    }
}
