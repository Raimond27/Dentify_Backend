<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AppointmentDto
{
    #[Assert\NotBlank]
    public ?int $pacienteId = null;

    #[Assert\NotBlank]
    public ?int $odontologoId = null;

    #[Assert\NotBlank]
    public ?int $boxId = null;

    #[Assert\NotBlank]
    #[Assert\Date]
    public ?string $fecha = null;

    #[Assert\NotBlank]
    #[Assert\Time]
    public ?string $horaInicio = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public ?string $duracion = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public ?string $estado = null;
}
