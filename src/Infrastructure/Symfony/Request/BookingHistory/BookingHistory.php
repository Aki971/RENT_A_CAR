<?php

namespace App\Infrastructure\Symfony\Request\BookingHistory;

use App\DTO\RequestParams\BookingHistoryParams;
use App\Infrastructure\Symfony\Request\NameRequirements;
use App\Infrastructure\Symfony\Request\Request;
use App\Request\BookingHistory\BookingHistory as BookingHistoryInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints\Date;

class BookingHistory extends Request implements BookingHistoryInterface
{
    public function params(): BookingHistoryParams
    {
        return new BookingHistoryParams(
            $this->getParameter(self::FIELD_USER_GUID),
            $this->getParameter(self::FIELD_VEHICLE_GUID),
            $this->getParameter(self::FIELD_BOOKING_START),
            $this->getParameter(self::FIELD_BOOKING_END),
            $this->getParameter(self::FIELD_APPROVED),

        );
    }

    protected function getTableName(): string
    {
        return 'booking_history';
    }

  
    protected function rules(): Collection
    {
    return new Collection([
        self::FIELD_USER_GUID => [
            new Uuid(),
        ],
        self::FIELD_VEHICLE_GUID => [
            new Uuid(),
        ],
        self::FIELD_BOOKING_START => [
            new Date(),
        ],
        self::FIELD_BOOKING_END => [
            new Date(),
        ],
        self::FIELD_APPROVED => [
            new Type('bool'),
        ]
    ]);
}


}