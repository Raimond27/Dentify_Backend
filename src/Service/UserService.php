<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\Odontologo;
use App\Repository\OdontologoRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private OdontologoRepository $repository
    ) {
        parent::__construct($entityManager);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): Odontologo
    {
        return $this->findOrThrow(Odontologo::class, $id);
    }

    public function create(UserDto $dto): Odontologo
    {
        $user = new Odontologo();
        $this->mapDtoToEntity($dto, $user);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return $user;
    }

    public function update(int $id, UserDto $dto): Odontologo
    {
        $user = $this->getById($id);
        $this->mapDtoToEntity($dto, $user);
        
        $this->entityManager->flush();
        
        return $user;
    }

    private function mapDtoToEntity(UserDto $dto, Odontologo $entity): void
    {
        $entity->setNombre($dto->nombre);
        $entity->setApellidos($dto->apellidos);
        $entity->setEmail($dto->email);
        $entity->setEspecialidad($dto->especialidad);
        $entity->setDiaSemanaAsignado($dto->diaSemanaAsignado);
    }
}
