<?php

declare(strict_types=1);

namespace App\Url;

use App\Entity\Url;
use App\Persistence\Persistence;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;

class Add
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Persistence $persistence,
        private readonly Generate $urlGenerator,
    ) {
    }

    /**
     * @throws Exception
     */
    public function createNewUrlEntry(array $data): Url
    {
        $url = new Url();
        $url->setRealUrl($data['real_url']);
        $url->setShortUrl($data['short_url'] ?? null);
        $url->setActive($data['active'] ?? true);
        try {
            $url->setUser($this->userRepository->find($data['user_id']));
        } catch (Exception) {
            throw new Exception('User not found');
        }

        try {
            $this->persistence->save($url);
        } catch (UniqueConstraintViolationException) {
            throw new Exception('Provided short URL is already in use');
        }
        $this->persistence->refresh($url);
        $this->addShortUrl($url);

        return $url;
    }

    private function addShortUrl(Url $url): void
    {
        if ($url->getShortUrl() === null) {
            $retry = 0;
            do {
                $created = $this->generateShortUrl($url, $retry === 0 ? null : $retry++);
            } while (!$created);
        }
    }

    private function generateShortUrl(Url $url, ?int $retry): bool
    {
        try {
            $url->setShortUrl($this->urlGenerator->generate($url->getId(), $retry));
            $this->persistence->save($url);
        } catch (Exception) {
            return false;
        }

        return true;
    }
}