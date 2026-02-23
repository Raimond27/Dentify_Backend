<?php

namespace App\Entity;

use App\Repository\StockMaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockMaterialRepository::class)]
class StockMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $cantidad = null;

    #[ORM\Column(length: 50)]
    private ?string $unidad = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fechaUltimaReposicion = null;

    #[ORM\OneToMany(targetEntity: RecepcionMaterial::class, mappedBy: 'material')]
    private Collection $recepciones;

    public function __construct()
    {
        $this->recepciones = new ArrayCollection();
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

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(string $cantidad): static
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): static
    {
        $this->unidad = $unidad;
        return $this;
    }

    public function getFechaUltimaReposicion(): ?\DateTimeImmutable
    {
        return $this->fechaUltimaReposicion;
    }

    public function setFechaUltimaReposicion(?\DateTimeImmutable $fechaUltimaReposicion): static
    {
        $this->fechaUltimaReposicion = $fechaUltimaReposicion;
        return $this;
    }

    /**
     * @return Collection<int, RecepcionMaterial>
     */
    public function getRecepciones(): Collection
    {
        return $this->recepciones;
    }

    public function addRecepcion(RecepcionMaterial $recepcion): static
    {
        if (!$this->recepciones->contains($recepcion)) {
            $this->recepciones->add($recepcion);
            $recepcion->setMaterial($this);
        }

        return $this;
    }

    public function removeRecepcion(RecepcionMaterial $recepcion): static
    {
        if ($this->recepciones->removeElement($recepcion)) {
            // set the owning side to null (unless already changed)
            if ($recepcion->getMaterial() === $this) {
                $recepcion->setMaterial(null);
            }
        }

        return $this;
    }
}
