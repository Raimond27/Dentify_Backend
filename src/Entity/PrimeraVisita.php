<?php

namespace App\Entity;

use App\Repository\PrimeraVisitaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrimeraVisitaRepository::class)]
class PrimeraVisita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Paciente::class, inversedBy: 'primeraVisitas')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Paciente $paciente = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motivoConsulta = null;

    #[ORM\ManyToOne(targetEntity: Odontograma::class, inversedBy: 'primeraVisitas')]
    private ?Odontograma $odontogramaInicial = null;

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

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getMotivoConsulta(): ?string
    {
        return $this->motivoConsulta;
    }

    public function setMotivoConsulta(?string $motivoConsulta): static
    {
        $this->motivoConsulta = $motivoConsulta;
        return $this;
    }

    public function getOdontogramaInicial(): ?Odontograma
    {
        return $this->odontogramaInicial;
    }

    public function setOdontogramaInicial(?Odontograma $odontogramaInicial): static
    {
        $this->odontogramaInicial = $odontogramaInicial;
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
