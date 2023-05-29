<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\DTO\RequestParams\PageParams;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Trait\HasGuidTrait;
use JsonSerializable;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: 'pages')]
#[ORM\HasLifecycleCallbacks]
class Page implements JsonSerializable, BaseEntityInterface
{
    use HasGuidTrait;
    use TimestampableTrait;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }

    public function update(PageParams $params): void
    {
        $this->title = $params->title;
        $this->content = $params->content;
        $this->image = $params->image;
    }
}
