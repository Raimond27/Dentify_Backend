<?php

namespace App\Entity;

use App\Repository\CitaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitaRepository::class)]
class Cita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Paciente::class, inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Paciente $paciente = null;

    #[ORM\ManyToOne(targetEntity: Odontologo::class, inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Odontologo $odontologo = null;

    #[ORM\ManyToOne(targetEntity: Box::class, inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Box $box = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $horaInicio = null;

    #[ORM\Column(length: 50)]
    private ?string $duracion = null;

    #[ORM\Column(length: 50)]
    private ?string $estado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;
        return $this;
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

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): static
    {
        $this->box = $box;
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

    public function getDuracion(): ?string
    {
        return $this->duracion;
    }

    public function setDuracion(string $duracion): static
    {
        $this->duracion = $duracion;
        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;
        return $this;
    }
}
