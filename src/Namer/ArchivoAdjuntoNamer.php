<?php

namespace App\Namer;

use App\Entity\API;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

/**
 * ArchivoAdjuntoNamer.
 */
class ArchivoAdjuntoNamer implements NamerInterface, DirectoryNamerInterface {

    /**
     * Creates a name for the file being uploaded.
     *
     * @param object $archivoAdjunto The object the upload is attached to.
     * @param Propertymapping $mapping The mapping to use to manipulate the given object.
     * @return string The file name.
     */
    public function name($archivoAdjunto, PropertyMapping $mapping): string {

        if (null !== $archivoAdjunto->getArchivo()) {

            $nombre = uniqid((new \DateTime())->format('Ymd_His') . '-');

            return API::stringCleaner($nombre) . "." . $archivoAdjunto->getArchivo()->getClientOriginalExtension();
        }
    }

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object          $object  The object the upload is attached to.
     * @param Propertymapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping): string {
        return $object->getCustomPath();
    }

}
