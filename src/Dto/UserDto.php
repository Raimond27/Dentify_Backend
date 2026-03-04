<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $nombre = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public ?string $apellidos = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    public ?string $email = null;

    #[Assert\Length(max: 255)]
    public ?string $especialidad = null;

    #[Assert\Length(max: 50)]
    public ?string $diaSemanaAsignado = null;
}
