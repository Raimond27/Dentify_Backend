<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Service\AppointmentService;
use App\Service\PatientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/appointments')]
class AppointmentController extends AbstractController
{
    public function __construct(
        private AppointmentService $appointmentService,
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $cita = new Cita();
        // Mapping logic here (simplified for skeleton)
        // ...
        
        if (!$this->appointmentService->isAvailable($cita)) {
            return $this->json(['error' => 'Specialist or Box not available'], Response::HTTP_CONFLICT);
        }

        $this->entityManager->persist($cita);
        $this->entityManager->flush();

        return $this->json($cita, Response::HTTP_CREATED);
    }
}
