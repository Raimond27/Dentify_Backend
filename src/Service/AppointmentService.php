<?php

namespace App\Service;

use App\Dto\AppointmentDto;
use App\Entity\Box;
use App\Entity\Cita;
use App\Entity\Odontologo;
use App\Entity\Paciente;
use App\Repository\CitaRepository;
use Doctrine\ORM\EntityManagerInterface;

class AppointmentService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private CitaRepository $repository
    ) {
        parent::__construct($entityManager);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): Cita
    {
        return $this->findOrThrow(Cita::class, $id);
    }

    public function create(AppointmentDto $dto): Cita
    {
        $appointment = new Cita();
        $this->mapDtoToEntity($dto, $appointment);
        
        $this->entityManager->persist($appointment);
        $this->entityManager->flush();
        
        return $appointment;
    }

    public function update(int $id, AppointmentDto $dto): Cita
    {
        $appointment = $this->getById($id);
        $this->mapDtoToEntity($dto, $appointment);
        
        $this->entityManager->flush();
        
        return $appointment;
    }

    private function mapDtoToEntity(AppointmentDto $dto, Cita $entity): void
    {
        $paciente = $this->findOrThrow(Paciente::class, $dto->pacienteId);
        $odontologo = $this->findOrThrow(Odontologo::class, $dto->odontologoId);
        $box = $this->findOrThrow(Box::class, $dto->boxId);

        $entity->setPaciente($paciente);
        $entity->setOdontologo($odontologo);
        $entity->setBox($box);
        
        $entity->setFecha(new \DateTimeImmutable($dto->fecha));
        $entity->setHoraInicio(new \DateTimeImmutable($dto->horaInicio));
        $entity->setDuracion($dto->duracion);
        $entity->setEstado($dto->estado);
    }
}
