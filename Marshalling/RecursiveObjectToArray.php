<?php
/**
 * Converts dto objects to arrays in order to create a middle step to serialize in
 * the espected format.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;
use Delr3ves\RestApiBundle\ApiObject\BasePaginatedApiObject;

class RecursiveObjectToArray {


    private $embeddedPropertiesUtils;

    public function __construct(EmbeddedPropertiesUtils $embeddedPropertiesUtils) {
        $this->embeddedPropertiesUtils = $embeddedPropertiesUtils;
    }

    /**
     *
     * @param $object
     * @param array $embedded
     * @param int $level
     */
    public function toArray($object, array $embedded, $deep=1) {
        if ($object instanceof BaseApiObject) {
            $deepIncrement = 1;
            if ($object instanceof BasePaginatedApiObject) {
                $deepIncrement = 0;
            }
            $objectAsArray = array();
            $classname = get_class($object);
            $reflectionClass = new \ReflectionClass($classname);
            foreach ($reflectionClass->getProperties() as $property) {
                if ($this->embeddedPropertiesUtils->haveToEmbedded(
                    $property, $embedded, $deep)) {

                    $propertyName = $property->getName();
                    $getterMethod = sprintf('get%s', ucfirst($propertyName));
                    $objectAsArray[$propertyName] =
                            $this->toArray($object->$getterMethod(), $embedded, $deep + $deepIncrement );
                }
            }
            return $objectAsArray;

        } else if (is_array($object)) {
            $list = array();
            foreach ($object as $key => $element) {
                $list[$key] = $this->toArray($element, $embedded, $deep);
            }
            return $list;
        } else if (is_string($object) || is_numeric($object) || is_bool($object)) {
            return $object;
        } else if (is_a($object, '\DateTime')) {
            return $object->format('c');
        }
    }
}
