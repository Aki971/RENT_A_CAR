<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use DateTime;
use App\DTO\User;
use App\DTO\Vehicle;
use App\DTO\BookingHistory as BookingHistoryDTO;
use App\Enum\Role;
use App\DTO\Position;
use App\Enum\DeskType;
use DateTimeImmutable;
use App\DTO\Dimensions;
use Doctrine\DBAL\Connection;
use App\Query\BookingHistoryInterface;
use App\DTO\Collection\BookingHistorys;

class BookingHistory implements BookingHistoryInterface
{
    const BOOKING_HISTORY_SELECT_QUERY = [
        'bh.guid as booking_history_guid',
        'bh.rented_by as booking_history_user_id',
        'bh.vehicles as booking_history_vehicle_id',
        'bh.booking_start as booking_history_booking_start',
        'bh.booking_end as booking_history_booking_end',
        'bh.approved as booking_history_approved',
        'bh.created_at as booking_history_created_at',
        'bh.updated_at as booking_history_updated_at',
        'u.guid as user_guid',
        'u.name as user_name',
        'u.last_name as user_last_name',
        'u.email as user_email',
        'u.password as user_password',
        'u.role as user_role',
        'u.image as user_image',
        'u.created_at as user_created_at',
        'u.updated_at as user_updated_at',
        'v.guid as vehicle_guid',
        'v.make as vehicle_make',
        'v.model as vehicle_model',
        'v.price as vehicle_price',
        'v.image as vehicle_image',
        'v.description as vehicle_description',
        'v.created_at as vehicle_created_at',
        'v.updated_at as vehicle_updated_at',
    ];

    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): BookingHistorys
    {
        $bookingHistorysData = $this->connection->createQueryBuilder()
            ->select(self::BOOKING_HISTORY_SELECT_QUERY)
            ->from('booking_history', 'bh')
            ->innerJoin('bh', 'users', 'u', 'u.guid = bh.rented_by')
            ->innerJoin('bh', 'vehicles', 'v', 'v.guid = bh.vehicles')
            ->fetchAllAssociative();

        return new BookingHistorys(
            array_map(fn(array $bookingHistoryData) => $this->createBookingHistoryDTO($bookingHistoryData), $bookingHistorysData)
        );
    }

    public function getByGuid(string $guid): ?BookingHistoryDTO
    {
        $bookingHistoryData = $this->connection->createQueryBuilder()
            ->select(self::BOOKING_HISTORY_SELECT_QUERY)
            ->from('booking_history', 'bh')
            ->innerJoin('bh', 'users', 'u', 'u.guid = bh.rented_by')
            ->innerJoin('bh', 'vehicles', 'v', 'v.guid = bh.vehicles')
            ->where('bh.guid = :guid')
            ->setParameter('guid', $guid)
            ->fetchAssociative();

        if (false === $bookingHistoryData) {
            return null;
        }

        return $this->createBookingHistoryDTO($bookingHistoryData);
    }

    public function getHistoryByUser(string $guid): BookingHistorys
    {
            $bookingHistorysData = $this->connection->createQueryBuilder()
            ->select(self::BOOKING_HISTORY_SELECT_QUERY)
            ->from('booking_history', 'bh')
            ->innerJoin('bh', 'users', 'u', 'u.guid = bh.user_id')
            ->innerJoin('bh', 'vehicles', 'v', 'v.guid = bh.vehicle_id')
            ->where('u.guid = :guid')
            ->setParameter('guid', $guid)
            ->fetchAllAssociative();

            return new BookingHistorys(
                array_map(fn(array $bookingHistoryData) => $this->createBookingHistoryDTO($bookingHistoryData), $bookingHistorysData)
            );
    }

    private function createBookingHistoryDTO(array $bookingHistoryData): BookingHistoryDTO
    {
        return new BookingHistoryDTO(
            $bookingHistoryData['booking_history_guid'],
            new User(
                $bookingHistoryData['user_guid'],
                $bookingHistoryData['user_name'],
                $bookingHistoryData['user_last_name'],
                $bookingHistoryData['user_email'],
                $bookingHistoryData['user_password'],
                Role::from($bookingHistoryData['user_role']),
                $bookingHistoryData['user_image'],
                new DateTimeImmutable($bookingHistoryData['user_created_at']),
                $bookingHistoryData['user_updated_at'] ?
                    new DateTime($bookingHistoryData['user_updated_at'])
                    :
                    null
            ),
            new Vehicle(
                $bookingHistoryData['vehicle_guid'],
                $bookingHistoryData['vehicle_make'],
                $bookingHistoryData['vehicle_model'],
                $bookingHistoryData['vehicle_price'],
                $bookingHistoryData['vehicle_image'],
                $bookingHistoryData['vehicle_description'],
                new DateTimeImmutable($bookingHistoryData['vehicle_created_at']),
                $bookingHistoryData['vehicle_updated_at'] ?
                    new DateTime($bookingHistoryData['vehicle_updated_at'])
                    :
                    null
            ),
            new DateTimeImmutable($bookingHistoryData['booking_history_booking_start']),
            new DateTimeImmutable($bookingHistoryData['booking_history_booking_end']),
            (bool) $bookingHistoryData['booking_history_approved'],
            new DateTimeImmutable($bookingHistoryData['booking_history_created_at']),
            $bookingHistoryData['booking_history_updated_at'] ?
                new DateTime($bookingHistoryData['booking_history_updated_at'])
                : null
        );
    }
}
