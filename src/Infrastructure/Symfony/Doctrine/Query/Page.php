<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Pages;
use App\DTO\Page as PageDTO;
use App\Query\PageInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class Page implements PageInterface
{
    private const SELECT_QUERY = [
        'p.guid as page_guid',
        'p.title as page_title',
        'p.content as page_content',
        'p.image as page_image',
        'p.created_at as page_created_at',
        'p.updated_at as page_updated_at',
    ];

    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): Pages
    {
        $pagesData = $this->connection->createQueryBuilder('pages')
            ->select(self::SELECT_QUERY)
            ->from('pages', 'p')
            ->orderBy('p.title', 'ASC')
            ->fetchAllAssociative();

        return new Pages(array_map(fn(array $pageData) => $this->createPageDTO($pageData), $pagesData));
    }

    public function getByGuid(string $guid): ?PageDTO
    {
        $pageData = $this->connection->createQueryBuilder()
            ->select(self::SELECT_QUERY)
            ->from('pages', 'p')
            ->where('p.guid = :guid')
            ->setParameter('guid', $guid)
            ->fetchAssociative();

        if (false === $pageData) {
            return null;
        }

        return $this->createPageDTO($pageData);
    }

    private function createPageDTO(array $pageData): PageDTO
    {
        return new PageDTO(
            $pageData['page_guid'],
            $pageData['page_title'],
            $pageData['page_content'],
            $pageData['page_image'],
            new DateTimeImmutable($pageData['page_created_at']),
            $pageData['page_updated_at'] ? new DateTime($pageData['page_updated_at']) : null,
        );
    }
}
