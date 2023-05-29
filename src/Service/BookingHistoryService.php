<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Collection\BookingHistorys;
use App\DTO\BookingHistory as BookingHistoryDTO;
use App\DTO\RequestParams\BookingHistoryParams;
use App\Entity\BookingHistory;
use App\Exception\Exists\Exists;
use App\Exception\NotFound\HistoryNotFoundException;
use App\Exception\NotFound\BookingHistoryNotFoundException;
use App\Exception\NotFound\VehicleNotFoundException;
use App\Exception\NotFound\UserNotFoundException;
use App\Query\BookingHistoryInterface;
use App\Repository\BookingHistoryRepository;
use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use DateTime;

class BookingHistoryService
{
    public function __construct(
        private readonly BookingHistoryRepository $bookingHistoryRepository,
        private readonly UserRepository $userRepository,
        private readonly VehicleRepository $vehicleRepository,
        private readonly BookingHistoryInterface $bookingHistoryQuery,
    ) {
    }

    public function getAll(): BookingHistorys
    {
        return $this->bookingHistoryQuery->getAll();
    }

    public function get(string $guid): BookingHistoryDTO
    {
        $bookingHistory = $this->bookingHistoryQuery->getByGuid($guid);

        if (null === $bookingHistory) {
            throw new BookingHistoryNotFoundException($guid);
        }

        return $bookingHistory;
    }

    public function create(BookingHistoryParams $params): string
    {
        $user = $this->userRepository->find($params->userGuid);

        if (null === $user) {
            throw new UserNotFoundException($params->userGuid);
        }

        $vehicle = $this->vehicleRepository->find($params->vehicleGuid);

        if (null === $vehicle) {
            throw new VehicleNotFoundException($params->vehicleGuid);
        }
        $this->checkIfVehicleIsAlreadyBooked($params);
        $bookingHistory = $this->bookingHistoryRepository->getEntityInstance();
        $bookingHistory->update($params, $user, $vehicle);
        $this->bookingHistoryRepository->save($bookingHistory);

        return $bookingHistory->getGuid();
    }

    public function updateByGuid(string $guid, BookingHistoryParams $params): void
    {
        $bookingHistory = $this->getHistoryBookingEntity($guid);
        $user = $this->userRepository->find($params->userGuid);

        if (null === $user) {
            throw new UserNotFoundException($params->userGuid);
        }

        $vehicle = $this->vehicleRepository->find($params->vehicleGuid);

        if (null === $vehicle) {
            throw new VehicleNotFoundException($params->vehicleGuid);
        }

        $this->checkIfVehicleIsAlreadyBooked($params);
        $bookingHistory->update($params, $user, $vehicle);
        $this->bookingHistoryRepository->save($bookingHistory);
    }

    public function deleteByGuid(string $guid): void
    {
        $bookingHistory = $this->getHistoryBookingEntity($guid);

        $this->bookingHistoryRepository->remove($bookingHistory);
    }

    public function getHistoryByUser(string $guid): BookingHistorys
    {
        return $this->bookingHistoryQuery->getHistoryByUser($guid);
    }

    private function getHistoryBookingEntity(string $guid): BookingHistory
    {
        $bookingHistory = $this->bookingHistoryRepository->find($guid);

        if (null === $bookingHistory) {
            throw new HistoryNotFoundException($guid);
        }

        return $bookingHistory;
    }

    private function checkIfVehicleIsAlreadyBooked(BookingHistoryParams $params): void
    {
        $bookingStart = new \DateTime($params->bookingStart);
        $bookingEnd = new \DateTime($params->bookingEnd);
    
        $existingBooking = $this->bookingHistoryRepository->createQueryBuilder('bh')
            ->andWhere('bh.vehicle = :vehicleGuid')
            ->andWhere('bh.bookingStart <= :bookingEnd')
            ->andWhere('bh.bookingEnd >= :bookingStart')
            ->setParameter('vehicleGuid', $params->vehicleGuid)
            ->setParameter('bookingStart', $bookingStart)
            ->setParameter('bookingEnd', $bookingEnd)
            ->getQuery()
            ->getOneOrNullResult();
    
        if (null !== $existingBooking) {
            throw new Exists(
                $params->bookingStart,
                'booking history',
                'bookingStart'
            );
        }
    }
    
}
