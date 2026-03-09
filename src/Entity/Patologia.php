<?php

namespace App\Entity;

use App\Repository\PatologiaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatologiaRepository::class)]
class Patologia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Odontograma::class, inversedBy: 'patologias')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Odontograma $odontograma = null;

    #[ORM\Column]
    private ?int $diente = null;

    #[ORM\Column(length: 50)]
    private ?string $cara = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoPatologia = null;

    #[ORM\Column(length: 50)]
    private ?string $estado = null;

    #[ORM\Column(length: 50)]
    private ?string $color = null;

    #[ORM\Column]
    private ?int $prioridad = null;

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

    public function getDiente(): ?int
    {
        return $this->diente;
    }

    public function setDiente(int $diente): static
    {
        $this->diente = $diente;

        return $this;
    }

    public function getCara(): ?string
    {
        return $this->cara;
    }

    public function setCara(string $cara): static
    {
        $this->cara = $cara;

        return $this;
    }

    public function getTipoPatologia(): ?string
    {
        return $this->tipoPatologia;
    }

    public function setTipoPatologia(string $tipoPatologia): static
    {
        $this->tipoPatologia = $tipoPatologia;

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

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPrioridad(): ?int
    {
        return $this->prioridad;
    }

    public function setPrioridad(int $prioridad): static
    {
        $this->prioridad = $prioridad;

        return $this;
    }
}
