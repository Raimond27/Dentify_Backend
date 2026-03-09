<?php

namespace App\Controller;

use App\Entity\StockMaterial;
use App\Entity\RecepcionMaterial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/stock')]
class StockController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $materials = $this->entityManager->getRepository(StockMaterial::class)->findAll();
        return $this->json($materials);
    }

    #[Route('/alerts', methods: ['GET'])]
    public function alerts(): JsonResponse
    {
        $repo = $this->entityManager->getRepository(StockMaterial::class);
        $lowStock = $repo->createQueryBuilder('s')
            ->where('s.cantidadActual < :min')
            ->setParameter('min', 10)
            ->getQuery()
            ->getResult();

        return $this->json($lowStock);
    }

    #[Route('/reception', methods: ['POST'])]
    public function addReception(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $material = $this->entityManager->getRepository(StockMaterial::class)->find($data['materialId']);
        if (!$material) {
            return $this->json(['error' => 'Material not found'], Response::HTTP_NOT_FOUND);
        }

        $reception = new RecepcionMaterial();
        $reception->setStockMaterial($material);
        $reception->setCantidadRecibida($data['cantidad']);
        $reception->setProveedor($data['proveedor']);
        $reception->setFecha(new \DateTimeImmutable());

        // Update stock
        $material->setCantidadActual($material->getCantidadActual() + $data['cantidad']);
        $material->setFechaUltimaReposicion(new \DateTimeImmutable());

        $this->entityManager->persist($reception);
        $this->entityManager->flush();

        return $this->json($reception, Response::HTTP_CREATED);
    }
}
