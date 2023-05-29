<?php

declare(strict_types=1);

namespace App\Request\Vehicle;

use App\DTO\RequestParams\VehicleParams;
use App\Request\Field\Make;
use App\Request\Field\Model;
use App\Request\Field\Guid;
use App\Request\Field\Price;
use App\Request\Field\Description;
use App\Request\Field\Image;

interface Vehicle extends
    Guid,
    Make,
    Model,
    Price,
    Description,
    Image
{
    public function params(): VehicleParams;
}