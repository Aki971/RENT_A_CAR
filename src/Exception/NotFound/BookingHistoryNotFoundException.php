<?php

namespace App\Exception\NotFound;

class BookingHistoryNotFoundException extends NotFoundException
{
    public function __construct(readonly string $bookingHistoryGuid)
    {
        parent::__construct($bookingHistoryGuid, 'booking history');
    }
}
