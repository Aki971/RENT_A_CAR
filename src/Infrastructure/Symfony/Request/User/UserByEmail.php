<?php

namespace App\Infrastructure\Symfony\Request\User;

use App\DTO\RequestParams\UserByEmailParams;
use App\Infrastructure\Symfony\Request\Request;
use App\Request\User\UserByEmail as UserRequestInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class UserByEmail extends Request implements UserRequestInterface
{
    public function params(): UserByEmailParams
    {
        return new UserByEmailParams(
            $this->getParameter(self::FIELD_EMAIL),
        );
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    protected function rules(): Collection
    {
        return new Collection([
            self::FIELD_EMAIL => [
                new Type('string'),
                new Length(
                    min: 22,
                    max: 50,
                    minMessage: 'Your email must be at least {{ limit }} characters long',
                    maxMessage: 'Your email cannot be longer than {{ limit }} characters',
                ),
                new Email()
            ],
        ]);
    }
}