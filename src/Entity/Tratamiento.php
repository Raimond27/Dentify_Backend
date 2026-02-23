<?php

namespace App\Entity;

use App\Repository\TratamientoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TratamientoRepository::class)]
class Tratamiento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Odontograma::class, inversedBy: 'tratamientos')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Odontograma $odontograma = null;

    #[ORM\Column(length: 50)]
    private ?string $diente = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cara = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoTratamiento = null;

    #[ORM\Column(length: 50)]
    private ?string $estado = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOdontograma(): ?Odontograma
    {
        return $this->odontograma;
    }

    public function setOdontograma(?Odontograma $odontograma): static
    {
        $this->odontograma = $odontograma;
        return $this;
    }

    public function getDiente(): ?string
    {
        return $this->diente;
    }

    public function setDiente(string $diente): static
    {
        $this->diente = $diente;
        return $this;
    }

    public function getCara(): ?string
    {
        return $this->cara;
    }

    public function setCara(?string $cara): static
    {
        $this->cara = $cara;
        return $this;
    }

    public function getTipoTratamiento(): ?string
    {
        return $this->tipoTratamiento;
    }

    public function setTipoTratamiento(string $tipoTratamiento): static
    {
        $this->tipoTratamiento = $tipoTratamiento;
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;
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
}
