<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: UrlRepository::class)]
class Url implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $realUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortUrl = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'urls')]
    private User $user;

    #[ORM\Column]
    private ?bool $active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealUrl(): ?string
    {
        return $this->realUrl;
    }

    public function setRealUrl(string $realUrl): static
    {
        $this->realUrl = $realUrl;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(?string $shortUrl): static
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'real_url' => $this->realUrl,
            'short_url' => $this->shortUrl,
            'active' => $this->active,
        ];
    }
}
