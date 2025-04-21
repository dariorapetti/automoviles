<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habilitado
 *
 */
trait Habilitado {

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean")
     */
    protected $habilitado;    

    /**
     * Set habilitado
     *
     * @param boolean $habilitado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    /**
     * Get habilitado
     *
     * @return boolean 
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

}
