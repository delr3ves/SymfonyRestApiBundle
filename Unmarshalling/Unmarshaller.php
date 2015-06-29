<?php
/**
 * In charge to un-marshall a string formatted object into a dto object.
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

interface Unmarshaller {

    /**
     * @param $payload string the given resource formated in $fomat typ e
     * @param $format string the current format to represent the payload
     * @param $classname string the classname of the constructed object.
     * @return object of class $classname.
     */
    public function unmarshall($payload, $format, $classname);

}
