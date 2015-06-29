<?php
/**
 * In charge to convert an array into an object with of the given class.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class RecursiveArrayToObjectBuilder {

    const BASIC_TYPE = 'basic';
    const OBJECT_TYPE = 'object';
    const LIST_TYPE = 'collection';

    /**
     * @var ApiAnnotationReader
     */
    private $apiAnnotationReader;

    public function __construct($apiAnnotationReader) {
        $this->apiAnnotationReader = $apiAnnotationReader;
    }

    public function build($value, $classname) {
        $valueType = $this->getValueType($value);
        switch ($valueType) {
            case self::BASIC_TYPE:
                return $this->processBasic($value, $classname);
            case self::OBJECT_TYPE:
                return $this->processObject($value, $classname );
            case self::LIST_TYPE:
                return $this->processArray($value, $classname);
        }
    }


    public function processObject($objectAsArray, $classname) {
        $reflectionClass = new \ReflectionClass($classname);
        $object = $reflectionClass->newInstanceArgs();

        foreach ($objectAsArray as $name => $value) {
            if ($reflectionClass->hasProperty($name)) {
                $setterMethod = sprintf('set%s', ucfirst($name));
                $property = $reflectionClass->getProperty($name);
                $propertyClass = $this->apiAnnotationReader->getPropertyType($property);
                $object->$setterMethod($this->build($value, $propertyClass));
            }
        }
        return $object;
    }


    public function processArray($array, $classname) {
        $result = array();
        foreach ($array as $element) {
            $result[] = $this->build($element, $classname);
        }
        return $result;
    }

    public function processBasic($value, $className) {
        $result = $value;
        if (class_exists($className)) {
            $r = new \ReflectionClass($className);
            $result = $r->newInstanceArgs(array($value));
        }
        return $result;
    }


    /**
     * Decides the type of the data according
     * @param $value
     * @return string
     */
    public function getValueType($value) {
        $valueType = self::BASIC_TYPE;
        if (is_array($value)) {
            if (count(array_filter(array_keys($value),'is_string')) == count($value)) {
                $valueType = self::OBJECT_TYPE;
            } else {
                $valueType = self::LIST_TYPE;
            }
        }
        return $valueType;
    }

}
