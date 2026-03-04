<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {}

    protected function findOrThrow(string $className, int $id): object
    {
        $entity = $this->entityManager->getRepository($className)->find($id);
        if (!$entity) {
            $parts = explode('\\', $className);
            $shortName = end($parts);
            throw new NotFoundHttpException("$shortName with ID $id not found");
        }
        return $entity;
    }

    public function delete(string $className, int $id): void
    {
        $entity = $this->findOrThrow($className, $id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
