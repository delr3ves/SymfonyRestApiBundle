<?php
/**
 * Reads a json string and returns the PHP object representation according to the
 * rules bellow:
 *
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */
namespace Delr3ves\RestApiBundle\Unmarshalling;

class JsonUnmarshaller implements SpecificFormatUnmarshaller {

    protected $arrayToObjectBuilder;

    public function __construct(RecursiveArrayToObjectBuilder $arrayToObjectBuilder) {
        $this->arrayToObjectBuilder = $arrayToObjectBuilder;
    }

    public function unmarshall($contents, $classname) {
            $objectAsArray = json_decode($contents, true);
            $object = $this->arrayToObjectBuilder->build($objectAsArray, $classname);
            return $object;
    }
}
