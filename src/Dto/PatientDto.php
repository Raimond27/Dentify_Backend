<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PatientDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $nombre = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $apellidos = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    public ?string $dni = null;

    #[Assert\Length(max: 255)]
    public ?string $numeroSeguridadSocial = null;

    #[Assert\Length(max: 20)]
    public ?string $telefono = null;

    #[Assert\Email]
    #[Assert\Length(max: 255)]
    public ?string $email = null;

    public array $alergias = [];

    #[Assert\Length(max: 255)]
    public ?string $enfermedades = null;

    public ?string $historialClinico = null;

    #[Assert\Length(max: 255)]
    public ?string $datosFacturacion = null;
}
