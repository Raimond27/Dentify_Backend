<?php

namespace App\Controller;

use App\Dto\DocumentDto;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/documents')]
class DocumentController extends AbstractController
{
    public function __construct(
        private DocumentService $service,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $documents = $this->service->getAll();
        return $this->json($documents);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $document = $this->service->getById($id);
        return $this->json($document);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), DocumentDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $document = $this->service->create($dto);
        return $this->json($document, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), DocumentDto::class, 'json');
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $document = $this->service->update($id, $dto);
        return $this->json($document);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete(\App\Entity\Radiografia::class, $id);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
