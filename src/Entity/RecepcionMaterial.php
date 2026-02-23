<?php

namespace App\Entity;

use App\Repository\RecepcionMaterialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecepcionMaterialRepository::class)]
class RecepcionMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: StockMaterial::class, inversedBy: 'recepciones')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?StockMaterial $material = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $cantidad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $proveedor = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterial(): ?StockMaterial
    {
        return $this->material;
    }

    public function setMaterial(?StockMaterial $material): static
    {
        $this->material = $material;
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

    public function getProveedor(): ?string
    {
        return $this->proveedor;
    }

    public function setProveedor(?string $proveedor): static
    {
        $this->proveedor = $proveedor;
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
