<?php

namespace App\Service;

use App\Entity\Cita;
use App\Repository\CitaRepository;
use App\Repository\HorarioRepository;

class AppointmentService
{
    public function __construct(
        private CitaRepository $citaRepository,
        private HorarioRepository $horarioRepository
    ) {}

    public function isAvailable(Cita $cita): bool
    {
        // Check specialist schedule
        $horario = $this->horarioRepository->findOneBy([
            'odontologo' => $cita->getOdontologo(),
            'fecha' => $cita->getFecha(),
            'diaSemana' => $this->getDiaSemana($cita->getFecha())
        ]);

        if (!$horario) {
            return false;
        }

        // Logic to check overlap in same box or same specialist
        return !$this->citaRepository->findOverlapping($cita);
    }

    private function getDiaSemana(\DateTimeImmutable $date): string
    {
        $days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        return $days[(int)$date->format('w')];
    }
}
