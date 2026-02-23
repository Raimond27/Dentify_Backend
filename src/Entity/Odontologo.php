<?php

namespace App\Entity;

use App\Repository\OdontologoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OdontologoRepository::class)]
class Odontologo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $especialidad = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $diaSemanaAsignado = null;

    #[ORM\OneToMany(targetEntity: Cita::class, mappedBy: 'odontologo')]
    private Collection $citas;

    public function __construct()
    {
        $this->citas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): static
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getEspecialidad(): ?string
    {
        return $this->especialidad;
    }

    public function setEspecialidad(?string $especialidad): static
    {
        $this->especialidad = $especialidad;
        return $this;
    }

    public function getDiaSemanaAsignado(): ?string
    {
        return $this->diaSemanaAsignado;
    }

    public function setDiaSemanaAsignado(?string $diaSemanaAsignado): static
    {
        $this->diaSemanaAsignado = $diaSemanaAsignado;
        return $this;
    }
}
