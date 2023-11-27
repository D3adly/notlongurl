<?php

declare(strict_types=1);

namespace App\Persistence;

use Doctrine\ORM\EntityManagerInterface;

class Persistence
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save($object, $commit = true): void
    {
        $this->entityManager->persist($object);
        if ($commit) {
            $this->commit();
        }
    }

    public function delete($object, $commit = true): void
    {
        $this->entityManager->remove($object);
        if ($commit) {
            $this->commit();
        }
    }

    public function commit(): void
    {
        $this->entityManager->flush();
    }

    public function refresh($object): void
    {
        $this->entityManager->refresh($object);
    }

    public function clear(?string $entityName = null): void
    {
        $this->entityManager->clear($entityName);
    }
}