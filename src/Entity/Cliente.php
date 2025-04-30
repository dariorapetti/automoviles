<?php

namespace App\Entity;

use App\Entity\VehiculoUsado;
use App\Entity\Traits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="fechaBaja")
 */
class Cliente
{
  use Traits\Auditoria;
  
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(name="razon_social", type="string", length=255, nullable=false)
   */
  private $nombre;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $direccion;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $telefono;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $email;

  /**
   * @ORM\OneToMany(targetEntity=VehiculoUsado::class, mappedBy="cliente", orphanRemoval=true)
   */
  private $vehiculos;

  /**
   * @ORM\Column(type="string", length=2000, nullable=true)
   */
  private $comentario;

  public function __construct()
  {
    $this->vehiculos = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNombre(): ?string
  {
    return $this->nombre;
  }

  public function setNombre(string $nombre): self
  {
    $this->nombre = $nombre;
    return $this;
  }

  public function getDireccion(): ?string
  {
    return $this->direccion;
  }

  public function setDireccion(string $direccion): self
  {
    $this->direccion = $direccion;
    return $this;
  }

  public function getTelefono(): ?string
  {
    return $this->telefono;
  }

  public function setTelefono(string $telefono): self
  {
    $this->telefono = $telefono;
    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }

  /**
   * @return Collection<int, VehiculoUsado>
   */
  public function getVehiculos(): Collection
  {
    return $this->vehiculos;
  }

  public function addVehiculo(VehiculoUsado $vehiculo): self
  {
    if (!$this->vehiculos->contains($vehiculo)) {
      $this->vehiculos[] = $vehiculo;
      $vehiculo->setCliente($this);
    }

    return $this;
  }

  public function removeVehiculo(VehiculoUsado $vehiculo): self
  {
    if ($this->vehiculos->removeElement($vehiculo)) {
      // set the owning side to null (unless already changed)
      if ($vehiculo->getCliente() === $this) {
        $vehiculo->setCliente(null);
      }
    }

    return $this;
  }

  public function __toString(): string {
      return $this->getNombre();
  }

  public function getComentario(): ?string
  {
    return $this->comentario;
  }

  public function setComentario(?string $comentario): self
  {
    $this->comentario = $comentario;

    return $this;
  }
}
