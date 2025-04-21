<?php

namespace App\Service;

use App\Entity\API;
use App\Entity\Constants\ConstanteAccionHistoricoEspecificacionesTecnicas;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of SelectService
 *
 * @author Darío Rapetti
 * created 28/09/2020
 */
class SelectService {

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->em = $entityManager;
    }

    /**
     * 
     * @return type
     */
    public function getPaisSelect($useId = false) {

        $em = $this->getEm();

        $sql = "SELECT x.id, x.nombre
                FROM App\Entity\Pais x 
                WHERE x.fechaBaja IS NULL 
                ORDER BY x.nombre ASC";

        $query = $em->createQuery($sql);

        $entities = $query->getArrayResult();

        return $this->getResponseData($entities, $useId);
    }

    /**
     * 
     * @param type $entities
     * @param type $useId
     * @param type $useEntities
     * @param type $showAll
     * @return string
     */
    public function getResponseData($entities, $useId = false, $useEntities = false, $showAll = true) {

        $responseData = $showAll ? "Todos:Todos;" : "";

        $count = count($entities);

        foreach ($entities as $entity) {

            $id = $useEntities ? $entity->getId() : $entity['id'];
            $text = $useEntities ? $entity->__toString() : $entity['nombre'];

            $responseData .= ($useId ? $id : $text) . ':' . $text;

            if (--$count > 0) {
                $responseData .= ';';
            }
        }

        return $responseData;
    }

    /**
     * 
     * @param type $useId
     * @return string
     */
    public function getMesesSelect($useId = false) {
        $months = API::getMonthArray();

        $responseData = "Todos:Todos;";

        $count = count($months);

        foreach ($months as $mes) {
            $id = $mes['id'];
            $text = $mes['denominacion'];

            $responseData .= ($useId ? $id : $text) . ':' . $text;

            if (--$count > 0) {
                $responseData .= ';';
            }
        }

        return $responseData;
    }

    /**
     * 
     * @param type $useId
     * @return string
     */
    public function getBooleanSelect($useId = false) {

        if($useId){
            return "Todos:Todos;0:No;1:S&iacute";
        } else {
            return ":Todos;No:No;Si:S&iacute";
        }            

    }
    
    private function getEm()
    {
        return $this->em;
    }

    /**
     * 
     * @return type
     */
    public function getEspecificacionesTecnicasCategoriaDocumentoTecnicoSelect($useId = false) {

        $em = $this->getEm();

        $sql = "SELECT x.id, x.denominacion AS nombre
                FROM App\Entity\EspecificacionesTecnicas\CategoriaDocumentoTecnico x 
                WHERE x.fechaBaja IS NULL 
                ORDER BY x.denominacion ASC";

        $query = $em->createQuery($sql);

        $entities = $query->getArrayResult();

        return $this->getResponseData($entities, $useId, false, true);
    }

    /**
     * 
     * @return type
     */
    public function getEspecificacionesTecnicasEstadoDocumentoTecnicoSelect($useId = false) {

        $em = $this->getEm();

        $sql = "SELECT x.id, x.denominacion AS nombre
                FROM App\Entity\EspecificacionesTecnicas\EstadoDocumentoTecnico x 
                ORDER BY x.denominacion ASC";

        $query = $em->createQuery($sql);

        $entities = $query->getArrayResult();

        return $this->getResponseData($entities, $useId, false, true);
    }

    /**
     * 
     * @return type
     */
    public function getEspecificacionesTecnicasAccionHistoricoSelect() {

        $responseData = "Todos:Todos;";

        $responseData .= ConstanteAccionHistoricoEspecificacionesTecnicas::DESCARGA . ':' . ConstanteAccionHistoricoEspecificacionesTecnicas::DESCARGA . ';';
        $responseData .= ConstanteAccionHistoricoEspecificacionesTecnicas::LOGIN . ':' . ConstanteAccionHistoricoEspecificacionesTecnicas::LOGIN . ';';
        $responseData .= ConstanteAccionHistoricoEspecificacionesTecnicas::LOGOUT . ':' . ConstanteAccionHistoricoEspecificacionesTecnicas::LOGOUT;

        return $responseData;
    }

    /**
     * 
     * @return type
     */
    public function getProcesosCategoriaSelect($useId = false) {

        $em = $this->getEm();

        $sql = "SELECT x.id, x.nombre
                FROM App\Entity\Procesos\Categoria x 
                ORDER BY x.nombre ASC";

        $query = $em->createQuery($sql);

        $entities = $query->getArrayResult();

        return $this->getResponseData($entities, $useId, false, true);
    }

    /**
     * 
     * @return type
     */
    public function getProcesosGerenciaSelect($useId = false) {

        $em = $this->getEm();

        $sql = "SELECT x.id, x.nombre
                FROM App\Entity\Procesos\Gerencia x 
                ORDER BY x.nombre ASC";

        $query = $em->createQuery($sql);

        $entities = $query->getArrayResult();

        return $this->getResponseData($entities, $useId, false, true);
    }

}
