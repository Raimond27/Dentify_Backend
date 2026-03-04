<?php

namespace App\Controller;

use App\Dto\OdontogramDto;
use App\Service\OdontogramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/odontograms')]
class OdontogramController extends AbstractController
{
    public function __construct(
        private OdontogramService $service,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $odontograms = $this->service->getAll();
        return $this->json($odontograms);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $odontogram = $this->service->getById($id);
        return $this->json($odontogram);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), OdontogramDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $odontogram = $this->service->create($dto);
        return $this->json($odontogram, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), OdontogramDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $odontogram = $this->service->update($id, $dto);
        return $this->json($odontogram);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete(\App\Entity\Odontograma::class, $id);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
