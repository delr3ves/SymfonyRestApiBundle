<?php
/**
 * Converts DTO objects into string representation according to the given format.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

interface Marshaller {

    /**
     * Marshall the object to json format.
     *
     * @param $object the objecte to be marshalled
     * @param array $embedded the list with the embedded elements we want to include in the response.
     * @return string the json string representing the current object.
     */
    public function marshall($object, $format, array $embedded = array());

}
