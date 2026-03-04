<?php

namespace App\Controller;

use App\Dto\AppointmentDto;
use App\Service\AppointmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/appointments')]
class AppointmentController extends AbstractController
{
    public function __construct(
        private AppointmentService $service,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $appointments = $this->service->getAll();
        return $this->json($appointments);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $appointment = $this->service->getById($id);
        return $this->json($appointment);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), AppointmentDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $appointment = $this->service->create($dto);
        return $this->json($appointment, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), AppointmentDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $appointment = $this->service->update($id, $dto);
        return $this->json($appointment);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete(\App\Entity\Cita::class, $id);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
