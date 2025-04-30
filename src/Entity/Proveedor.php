<?php

namespace App\Entity;

use App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="fechaBaja")
 */
class Proveedor
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
    private $razonSocial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono_operador", type="string", length=255)
     */
    private $telefonoOperador;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $comentario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(string $razonSocial): self
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    public function __toString(): string {
        return $this->getRazonSocial();
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

    public function getTelefonoOperador(): ?string
    {
        return $this->telefonoOperador;
    }

    public function setTelefonoOperador(string $telefonoOperador): self
    {
        $this->telefonoOperador = $telefonoOperador;

        return $this;
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
