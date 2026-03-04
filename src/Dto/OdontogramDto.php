<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OdontogramDto
{
    #[Assert\NotBlank]
    public ?int $pacienteId = null;

    #[Assert\Type('array')]
    public array $dientes = [];
}
