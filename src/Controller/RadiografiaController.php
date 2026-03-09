<?php

namespace App\Controller;

use App\Entity\Radiografia;
use App\Entity\Paciente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/radiographies')]
class RadiografiaController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/upload', methods: ['POST'])]
    public function upload(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        $patientId = $request->request->get('patientId');
        
        $patient = $this->entityManager->getRepository(Paciente::class)->find($patientId);
        if (!$patient) {
            return $this->json(['error' => 'Patient not found'], Response::HTTP_NOT_FOUND);
        }

        // Deactivate old radiographies for this patient
        $this->entityManager->getRepository(Radiografia::class)
            ->createQueryBuilder('r')
            ->update()
            ->set('r.activa', 'false')
            ->where('r.paciente = :p')
            ->setParameter('p', $patient)
            ->getQuery()
            ->execute();

        $radiografia = new Radiografia();
        $radiografia->setPaciente($patient);
        $radiografia->setNombreArchivo($file->getClientOriginalName()); // Stub for actual moving
        $radiografia->setFechaSubida(new \DateTimeImmutable());
        $radiografia->setActiva(true);

        $this->entityManager->persist($radiografia);
        $this->entityManager->flush();

        return $this->json($radiografia, Response::HTTP_CREATED);
    }
}
