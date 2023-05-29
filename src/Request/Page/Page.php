<?php

declare(strict_types=1);

namespace App\Request\Page;

use App\DTO\RequestParams\PageParams;
use App\Request\Field\Guid;
use App\Request\Field\Image;
use App\Request\Field\Title;
use App\Request\Field\Content;


interface Page extends
    Guid,
    Title,
    Content,
    Image
{
    public function params(): PageParams;
}
