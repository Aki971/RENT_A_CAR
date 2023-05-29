<?php

namespace App\Infrastructure\Symfony\Request\Page;

use App\DTO\RequestParams\PageParams;
use App\Infrastructure\Symfony\Request\NameRequirements;
use App\Infrastructure\Symfony\Request\Request;
use App\Request\Page\Page as PageRequestInteface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;

class Page extends Request implements PageRequestInteface
{
    public function params(): PageParams
    {
        return new PageParams(
            $this->getParameter(self::FIELD_TITLE),
            $this->getParameter(self::FIELD_CONTENT),
            $this->getParameter(self::FIELD_IMAGE)
        );
    }

    protected function getTableName(): string
    {
        return 'pages';
    }

    protected function rules(): Collection
    {
        return new Collection([
            self::FIELD_TITLE => [
                new NameRequirements(),
            ],
            self::FIELD_CONTENT => [
                new Type('string'),
                new Length(
                    min: 2,
                    max: 500,
                    minMessage: 'Your content must be at least {{ limit }} characters long',
                    maxMessage: 'Your content cannot be longer than {{ limit }} characters',
                ),
            ],
            self::FIELD_IMAGE => [
                new Type('string'),
                new Url()
            ]
        ]);
    }
}