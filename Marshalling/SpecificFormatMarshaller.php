<?php
/**
 * Converts an object into a specifict formated string (like XML or Json).
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\Marshalling\RecursiveObjectToArray;

interface SpecificFormatMarshaller {

    /**
     * Marshall the object to a specific format.
     *
     * @param $object the objecte to be marshalled
     * @param array $embedded the list with the embedded elements we want to include in the response.
     *
     * @return string the json string representing the current object.
     */
    public function marshall($object, array $embedded = array());

}