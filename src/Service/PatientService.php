<?php

namespace App\Service;

use App\Dto\PatientDto;
use App\Entity\Paciente;
use App\Repository\PacienteRepository;
use Doctrine\ORM\EntityManagerInterface;

class PatientService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private PacienteRepository $repository
    ) {
        parent::__construct($entityManager);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): Paciente
    {
        return $this->findOrThrow(Paciente::class, $id);
    }

    public function create(PatientDto $dto): Paciente
    {
        $patient = new Paciente();
        $this->mapDtoToEntity($dto, $patient);
        
        $this->entityManager->persist($patient);
        $this->entityManager->flush();
        
        return $patient;
    }

    public function update(int $id, PatientDto $dto): Paciente
    {
        $patient = $this->getById($id);
        $this->mapDtoToEntity($dto, $patient);
        
        $this->entityManager->flush();
        
        return $patient;
    }

    private function mapDtoToEntity(PatientDto $dto, Paciente $entity): void
    {
        $entity->setNombre($dto->nombre);
        $entity->setApellidos($dto->apellidos);
        $entity->setDni($dto->dni);
        $entity->setNumeroSeguridadSocial($dto->numeroSeguridadSocial);
        $entity->setTelefono($dto->telefono);
        $entity->setEmail($dto->email);
        $entity->setAlergias($dto->alergias);
        $entity->setEnfermedades($dto->enfermedades);
        $entity->setHistorialClinico($dto->historialClinico);
        $entity->setDatosFacturacion($dto->datosFacturacion);
    }
}
