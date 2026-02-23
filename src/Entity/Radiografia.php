<?php

namespace App\Entity;

use App\Repository\RadiografiaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RadiografiaRepository::class)]
class Radiografia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Paciente::class, inversedBy: 'radiografias')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Paciente $paciente = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreArchivo = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tipoRadiografia = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $fechaSubida = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

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

    public function getNombreArchivo(): ?string
    {
        return $this->nombreArchivo;
    }

    public function setNombreArchivo(string $nombreArchivo): static
    {
        $this->nombreArchivo = $nombreArchivo;
        return $this;
    }

    public function getTipoRadiografia(): ?string
    {
        return $this->tipoRadiografia;
    }

    public function setTipoRadiografia(?string $tipoRadiografia): static
    {
        $this->tipoRadiografia = $tipoRadiografia;
        return $this;
    }

    public function getFechaSubida(): ?\DateTimeImmutable
    {
        return $this->fechaSubida;
    }

    public function setFechaSubida(\DateTimeImmutable $fechaSubida): static
    {
        $this->fechaSubida = $fechaSubida;
        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;
        return $this;
    }
}
