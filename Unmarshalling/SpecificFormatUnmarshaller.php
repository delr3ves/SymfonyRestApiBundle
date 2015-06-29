<?php
/**
 * Converts an specifict formated string (XML, Json, etc.) to an object.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

use Delr3ves\RestApiBundle\Marshalling\RecursiveObjectToArray;

interface SpecificFormatUnmarshaller {

    /**
     * Unmarshall the object to a specific format.
     *
     * @param $object the string formated object to be unmarshalled
     * @param the classname of the object to be built.
     *
     * @return string the oject that match with the given string.
     */
    public function unmarshall($object, $classname);

}