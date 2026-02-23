<?php

namespace App\Entity;

use App\Repository\OdontogramaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OdontogramaRepository::class)]
class Odontograma
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Paciente::class, inversedBy: 'odontogramas')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Paciente $paciente = null;

    #[ORM\Column(type: Types::JSON)]
    private array $dientes = [];

    #[ORM\OneToMany(targetEntity: Tratamiento::class, mappedBy: 'odontograma')]
    private Collection $tratamientos;

    #[ORM\OneToMany(targetEntity: PrimeraVisita::class, mappedBy: 'odontogramaInicial')]
    private Collection $primeraVisitas;

    public function __construct()
    {
        $this->tratamientos = new ArrayCollection();
        $this->primeraVisitas = new ArrayCollection();
    }

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

    public function getDientes(): array
    {
        return $this->dientes;
    }

    public function setDientes(array $dientes): static
    {
        $this->dientes = $dientes;
        return $this;
    }

    /**
     * @return Collection<int, Tratamiento>
     */
    public function getTratamientos(): Collection
    {
        return $this->tratamientos;
    }

    public function addTratamiento(Tratamiento $tratamiento): static
    {
        if (!$this->tratamientos->contains($tratamiento)) {
            $this->tratamientos->add($tratamiento);
            $tratamiento->setOdontograma($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): static
    {
        if ($this->tratamientos->removeElement($tratamiento)) {
            // set the owning side to null (unless already changed)
            if ($tratamiento->getOdontograma() === $this) {
                $tratamiento->setOdontograma(null);
            }
        }

        return $this;
    }
}
