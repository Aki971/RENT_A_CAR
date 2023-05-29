<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Collection\Pages;
use App\DTO\RequestParams\PageParams;
use App\DTO\Page as PageDTO;
use App\Entity\Page;
use App\Exception\NotFound\PageNotFoundException;
use App\Query\PageInterface;
use App\Repository\PageRepository;
use DateTime;
use Ramsey\Uuid\Nonstandard\Uuid;

class PageService
{
    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly PageInterface $pageQuery,
    ) {
    }

    public function getAll(): Pages
    {
        return $this->pageQuery->getAll();
    }

    public function get(string $guid): PageDTO
    {
        $page = $this->pageQuery->getByGuid($guid);

        if (null === $page) {
            throw new PageNotFoundException($guid);
        }

        return $page;
    }

    public function create(PageParams $params): string
    {
        $page = $this->pageRepository->getEntityInstance();
        $page->update($params);
        $this->pageRepository->save($page);

        return $page->getGuid();
    }

    public function updateByGuid(string $guid, PageParams $params): void
    {
        $page = $this->findPage($guid);
        $page->update($params);

        $this->pageRepository->save($page);
    }

    public function deleteByGuid(string $guid): void
    {
        $page = $this->findPage($guid);

        $this->pageRepository->remove($page);
    }

    private function findPage(string $guid): Page
    {
        $page = $this->pageRepository->find($guid);

        if (null === $page) {
            throw new PageNotFoundException($guid);
        }

        return $page;
    }

}
