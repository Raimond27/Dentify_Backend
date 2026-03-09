<?php

namespace App\Entity;

use App\Repository\HorarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorarioRepository::class)]
class Horario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Odontologo::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Odontologo $odontologo = null;

    #[ORM\Column(length: 20)]
    private ?string $diaSemana = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $horaInicio = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $horaFin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOdontologo(): ?Odontologo
    {
        return $this->odontologo;
    }

    public function setOdontologo(?Odontologo $odontologo): static
    {
        $this->odontologo = $odontologo;

        return $this;
    }

    public function getDiaSemana(): ?string
    {
        return $this->diaSemana;
    }

    public function setDiaSemana(string $diaSemana): static
    {
        $this->diaSemana = $diaSemana;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHoraInicio(): ?\DateTimeImmutable
    {
        return $this->horaInicio;
    }

    public function setHoraInicio(\DateTimeImmutable $horaInicio): static
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    public function getHoraFin(): ?\DateTimeImmutable
    {
        return $this->horaFin;
    }

    public function setHoraFin(\DateTimeImmutable $horaFin): static
    {
        $this->horaFin = $horaFin;

        return $this;
    }
}
