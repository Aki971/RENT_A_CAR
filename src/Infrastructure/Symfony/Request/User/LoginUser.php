<?php

namespace App\Infrastructure\Symfony\Request\User;

use App\DTO\RequestParams\LoginUserParams;
use App\Enum\Role;
use App\Infrastructure\Symfony\Request\NameRequirements;
use App\Infrastructure\Symfony\Request\Request;
use App\Request\User\LoginUser as LoginUserInteface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;

class LoginUser extends Request implements LoginUserInteface
{
    public function params(): LoginUserParams
    {
        return new LoginUserParams(
            $this->getParameter(self::FIELD_EMAIL),
            $this->getParameter(self::FIELD_PASSWORD),
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
                    min: 15,
                    max: 50,
                    minMessage: 'Your email must be at least {{ limit }} characters long',
                    maxMessage: 'Your email cannot be longer than {{ limit }} characters',
                ),
                new Email()
            ],
            self::FIELD_PASSWORD => [
                new Type('string'),
                new Length(
                    min: 2,
                    max: 64,
                    minMessage: 'Your password must be at least {{ limit }} characters long',
                    maxMessage: 'Your password cannot be longer than {{ limit }} characters',
                ),
            ]
        ]);
    }
}