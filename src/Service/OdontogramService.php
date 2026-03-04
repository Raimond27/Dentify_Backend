<?php

namespace App\Service;

use App\Dto\OdontogramDto;
use App\Entity\Odontograma;
use App\Entity\Paciente;
use App\Repository\OdontogramaRepository;
use Doctrine\ORM\EntityManagerInterface;

class OdontogramService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private OdontogramaRepository $repository
    ) {
        parent::__construct($entityManager);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getByPatient(int $patientId): array
    {
        return $this->repository->findBy(['paciente' => $patientId]);
    }

    public function getById(int $id): Odontograma
    {
        return $this->findOrThrow(Odontograma::class, $id);
    }

    public function create(OdontogramDto $dto): Odontograma
    {
        $odontogram = new Odontograma();
        $this->mapDtoToEntity($dto, $odontogram);
        
        $this->entityManager->persist($odontogram);
        $this->entityManager->flush();
        
        return $odontogram;
    }

    public function update(int $id, OdontogramDto $dto): Odontograma
    {
        $odontogram = $this->getById($id);
        $this->mapDtoToEntity($dto, $odontogram);
        
        $this->entityManager->flush();
        
        return $odontogram;
    }

    private function mapDtoToEntity(OdontogramDto $dto, Odontograma $entity): void
    {
        $paciente = $this->findOrThrow(Paciente::class, $dto->pacienteId);
        $entity->setPaciente($paciente);
        $entity->setDientes($dto->dientes);
    }
}
