<?php

namespace App\Infrastructure\Symfony\Request\Vehicle;

use App\DTO\RequestParams\VehicleParams;
use App\Infrastructure\Symfony\Request\NameRequirements;
use App\Infrastructure\Symfony\Request\Request;
use App\Request\Vehicle\Vehicle as VehicleRequestInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;

class Vehicle extends Request implements VehicleRequestInterface
{
    public function params(): VehicleParams
    {
        return new VehicleParams(
            $this->getParameter(self::FIELD_MAKE),
            $this->getParameter(self::FIELD_MODEL),
            $this->getParameter(self::FIELD_PRICE),
            $this->getParameter(self::FIELD_DESCRIPTION),
            $this->getParameter(self::FIELD_IMAGE)
        );
    }

    protected function getTableName(): string
    {
        return 'vehicles';
    }

    protected function rules(): Collection
    {
        return new Collection([
            self::FIELD_MAKE => [
                new NameRequirements(),
            ],
            self::FIELD_MODEL => [
                new NameRequirements(),
            ],
            self::FIELD_DESCRIPTION => [
                new Type('string'),
                new Length(
                    min: 2,
                    max: 255,
                    minMessage: 'Your description must be at least {{ limit }} characters long',
                    maxMessage: 'Your description cannot be longer than {{ limit }} characters',
                ),
            ],
            self::FIELD_PRICE => [
                new Type('integer'),
            ],
            self::FIELD_IMAGE => [
                new Type('string'),
                new Url()
            ]
        ]);
    }
}