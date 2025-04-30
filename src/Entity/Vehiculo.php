<?php

namespace App\Entity;

use App\Entity\Traits\Auditoria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminador", type="string")
 * @ORM\DiscriminatorMap({"vehiculo" = "Vehiculo", "cero" = "VehiculoCero", "usado" = "VehiculoUsado"})
 * @Gedmo\SoftDeleteable(fieldName="fechaBaja")
 */
class Vehiculo {

    use Auditoria;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dominio;

    /**
     * @ORM\ManyToOne(targetEntity=Marca::class)
     * @ORM\JoinColumn(name="id_marca", referencedColumnName="id", nullable=false)
     */
    private $marca;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $modelo;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $tipo;

    /**
     * @ORM\Column(name="numero_motor", type="string", length=255, nullable=false)
     */
    private $numeroMotor;

    /**
     * @ORM\Column(name="numero_chasis", type="string", length=255, nullable=false)
     */
    private $numeroChasis;

    /**
     * @ORM\Column(name="cotizacion_dolar", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $cotizacionDolar;

    /**
     * @ORM\Column(name="precio_compra_usd", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioCompraUsd;

    /**
     * @ORM\Column(name="precio_venta_usd", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioVentaUsd;

    /**
     * @ORM\Column(name="precio_compra_pesos", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioCompraPesos;

    /**
     * @ORM\Column(name="precio_venta_pesos", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $precioVentaPesos;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $comentario;

    public function getId(): ?int {
        return $this->id;
    }

    public function getDominio(): ?string
    {
        return $this->dominio;
    }

    public function setDominio(string $dominio): self
    {
        $this->dominio = $dominio;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNumeroMotor(): ?string
    {
        return $this->numeroMotor;
    }

    public function setNumeroMotor(string $numeroMotor): self
    {
        $this->numeroMotor = $numeroMotor;

        return $this;
    }

    public function getNumeroChasis(): ?string
    {
        return $this->numeroChasis;
    }

    public function setNumeroChasis(string $numeroChasis): self
    {
        $this->numeroChasis = $numeroChasis;

        return $this;
    }

    public function getCotizacionDolar(): ?string
    {
        return $this->cotizacionDolar;
    }

    public function setCotizacionDolar(string $cotizacionDolar): self
    {
        $this->cotizacionDolar = $cotizacionDolar;

        return $this;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getPrecioCompraUsd(): ?string
    {
        return $this->precioCompraUsd;
    }

    public function setPrecioCompraUsd(?string $precioCompraUsd): self
    {
        $this->precioCompraUsd = $precioCompraUsd;

        return $this;
    }

    public function getPrecioVentaUsd(): ?string
    {
        return $this->precioVentaUsd;
    }

    public function setPrecioVentaUsd(?string $precioVentaUsd): self
    {
        $this->precioVentaUsd = $precioVentaUsd;

        return $this;
    }

    public function getPrecioCompraPesos(): ?string
    {
        return $this->precioCompraPesos;
    }

    public function setPrecioCompraPesos(?string $precioCompraPesos): self
    {
        $this->precioCompraPesos = $precioCompraPesos;

        return $this;
    }

    public function getPrecioVentaPesos(): ?string
    {
        return $this->precioVentaPesos;
    }

    public function setPrecioVentaPesos(?string $precioVentaPesos): self
    {
        $this->precioVentaPesos = $precioVentaPesos;

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
