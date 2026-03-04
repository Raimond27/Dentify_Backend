<?php

namespace App\Service;

use App\Dto\DocumentDto;
use App\Entity\Paciente;
use App\Entity\Radiografia;
use App\Repository\RadiografiaRepository;
use Doctrine\ORM\EntityManagerInterface;

class DocumentService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private RadiografiaRepository $repository
    ) {
        parent::__construct($entityManager);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): Radiografia
    {
        return $this->findOrThrow(Radiografia::class, $id);
    }

    public function create(DocumentDto $dto): Radiografia
    {
        $document = new Radiografia();
        $this->mapDtoToEntity($dto, $document);
        $document->setFechaSubida(new \DateTimeImmutable());
        
        $this->entityManager->persist($document);
        $this->entityManager->flush();
        
        return $document;
    }

    public function update(int $id, DocumentDto $dto): Radiografia
    {
        $document = $this->getById($id);
        $this->mapDtoToEntity($dto, $document);
        
        $this->entityManager->flush();
        
        return $document;
    }

    private function mapDtoToEntity(DocumentDto $dto, Radiografia $entity): void
    {
        $paciente = $this->findOrThrow(Paciente::class, $dto->pacienteId);
        $entity->setPaciente($paciente);
        $entity->setNombreArchivo($dto->nombreArchivo);
        $entity->setTipoRadiografia($dto->tipoRadiografia);
        $entity->setObservaciones($dto->observaciones);
    }
}
