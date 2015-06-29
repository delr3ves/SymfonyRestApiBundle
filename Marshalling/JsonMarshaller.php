<?php
/**
 * Converts an object into a json string.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\Marshalling\RecursiveObjectToArray;

class JsonMarshaller implements SpecificFormatMarshaller {

    protected  $recursiveObjectToArray;

    public function __construct(RecursiveObjectToArray $recursiveObjectToArray) {
        $this->recursiveObjectToArray = $recursiveObjectToArray;
    }

    /**
     * Marshall the given object to a json string.
     * @see SpecificFormatMarshaller::marshall()
     */
    public function marshall($object, array $embedded = array()) {
        $objectAsArray = $this->recursiveObjectToArray->toArray(
                $object, $embedded, 1);
        $json =  \json_encode($objectAsArray,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        return $json;
    }
}