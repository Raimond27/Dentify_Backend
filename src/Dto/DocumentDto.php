<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class DocumentDto
{
    #[Assert\NotBlank]
    public ?int $pacienteId = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $nombreArchivo = null;

    #[Assert\Length(max: 100)]
    public ?string $tipoRadiografia = null;

    public ?string $observaciones = null;
}
