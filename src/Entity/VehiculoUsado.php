<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class VehiculoUsado extends Vehiculo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $anio;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometros;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class, inversedBy="vehiculos")
     * @ORM\JoinColumn(name="id_cliente", nullable=true)
     */
    private $cliente;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $precioRevista;

    /**
     * @ORM\Column(type="boolean")
     */
    private $kitSeguridad;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cubreAlfombras;

    /**
     * @ORM\Column(type="boolean")
     */
    private $titulo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cedulaVerde;

    /**
     * @ORM\Column(type="boolean")
     */
    private $formulario08;

    /**
     * @ORM\Column(type="boolean")
     */
    private $grabadoAutopartes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $duplicadoLlaves;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $vencimientoGnc;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $vencimientoVtv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $informeDominio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $patentes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getKilometros(): ?int
    {
        return $this->kilometros;
    }

    public function setKilometros(int $kilometros): self
    {
        $this->kilometros = $kilometros;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getPrecioRevista(): ?string
    {
        return $this->precioRevista;
    }

    public function setPrecioRevista(?string $precioRevista): self
    {
        $this->precioRevista = $precioRevista;

        return $this;
    }

    public function getKitSeguridad(): ?bool
    {
        return $this->kitSeguridad;
    }

    public function setKitSeguridad(bool $kitSeguridad): self
    {
        $this->kitSeguridad = $kitSeguridad;

        return $this;
    }

    public function getCubreAlfombras(): ?bool
    {
        return $this->cubreAlfombras;
    }

    public function setCubreAlfombras(bool $cubreAlfombras): self
    {
        $this->cubreAlfombras = $cubreAlfombras;

        return $this;
    }

    public function getTitulo(): ?bool
    {
        return $this->titulo;
    }

    public function setTitulo(bool $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getCedulaVerde(): ?bool
    {
        return $this->cedulaVerde;
    }

    public function setCedulaVerde(bool $cedulaVerde): self
    {
        $this->cedulaVerde = $cedulaVerde;

        return $this;
    }

    public function getFormulario08(): ?bool
    {
        return $this->formulario08;
    }

    public function setFormulario08(bool $formulario08): self
    {
        $this->formulario08 = $formulario08;

        return $this;
    }

    public function getGrabadoAutopartes(): ?bool
    {
        return $this->grabadoAutopartes;
    }

    public function setGrabadoAutopartes(bool $grabadoAutopartes): self
    {
        $this->grabadoAutopartes = $grabadoAutopartes;

        return $this;
    }

    public function getDuplicadoLlaves(): ?bool
    {
        return $this->duplicadoLlaves;
    }

    public function setDuplicadoLlaves(bool $duplicadoLlaves): self
    {
        $this->duplicadoLlaves = $duplicadoLlaves;

        return $this;
    }

    public function getVencimientoGnc(): ?\DateTimeInterface
    {
        return $this->vencimientoGnc;
    }

    public function setVencimientoGnc( ? \DateTimeInterface $vencimientoGnc) : self
    {
        $this->vencimientoGnc = $vencimientoGnc;

        return $this;
    }

    public function getVencimientoVtv(): ?\DateTimeInterface
    {
        return $this->vencimientoVtv;
    }

    public function setVencimientoVtv( ? \DateTimeInterface $vencimientoVtv) : self
    {
        $this->vencimientoVtv = $vencimientoVtv;

        return $this;
    }

    public function getInformeDominio(): ?string
    {
        return $this->informeDominio;
    }

    public function setInformeDominio(?string $informeDominio): self
    {
        $this->informeDominio = $informeDominio;

        return $this;
    }

    public function getPatentes(): ?string
    {
        return $this->patentes;
    }

    public function setPatentes(?string $patentes): self
    {
        $this->patentes = $patentes;

        return $this;
    }
}
