<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacienteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Paciente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 20)]
    private ?string $dni = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroSeguridadSocial = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $alergias = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enfermedades = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $historialClinico = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $datosFacturacion = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaCreacion = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fechaModificacion = null;

    #[ORM\OneToMany(targetEntity: Cita::class, mappedBy: 'paciente')]
    private Collection $citas;

    #[ORM\OneToMany(targetEntity: Odontograma::class, mappedBy: 'paciente')]
    private Collection $odontogramas;

    #[ORM\OneToMany(targetEntity: Radiografia::class, mappedBy: 'paciente')]
    private Collection $radiografias;

    #[ORM\OneToMany(targetEntity: PrimeraVisita::class, mappedBy: 'paciente')]
    private Collection $primeraVisitas;

    public function __construct()
    {
        $this->citas = new ArrayCollection();
        $this->odontogramas = new ArrayCollection();
        $this->radiografias = new ArrayCollection();
        $this->primeraVisitas = new ArrayCollection();
        $this->fechaCreacion = new \DateTimeImmutable();
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

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;
        return $this;
    }

    public function getNumeroSeguridadSocial(): ?string
    {
        return $this->numeroSeguridadSocial;
    }

    public function setNumeroSeguridadSocial(?string $numeroSeguridadSocial): static
    {
        $this->numeroSeguridadSocial = $numeroSeguridadSocial;
        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getAlergias(): array
    {
        return $this->alergias;
    }

    public function setAlergias(?array $alergias): static
    {
        $this->alergias = $alergias ?? [];
        return $this;
    }

    public function getEnfermedades(): ?string
    {
        return $this->enfermedades;
    }

    public function setEnfermedades(?string $enfermedades): static
    {
        $this->enfermedades = $enfermedades;
        return $this;
    }

    public function getHistorialClinico(): ?string
    {
        return $this->historialClinico;
    }

    public function setHistorialClinico(?string $historialClinico): static
    {
        $this->historialClinico = $historialClinico;
        return $this;
    }

    public function getDatosFacturacion(): ?string
    {
        return $this->datosFacturacion;
    }

    public function setDatosFacturacion(?string $datosFacturacion): static
    {
        $this->datosFacturacion = $datosFacturacion;
        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeImmutable
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeImmutable $fechaCreacion): static
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
    }

    public function getFechaModificacion(): ?\DateTimeImmutable
    {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion(?\DateTimeImmutable $fechaModificacion): static
    {
        $this->fechaModificacion = $fechaModificacion;
        return $this;
    }

    #[ORM\PreUpdate]
    public function setFechaModificacionValue(): void
    {
        $this->fechaModificacion = new \DateTimeImmutable();
    }
}
