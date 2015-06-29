<?php
/**
 * In charge to generate some example data for ApiObjects.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 */
namespace Delr3ves\RestApiBundle\Docs;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class ApiObjectPopulator {
    /**
     * @var \Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader
     */
    private $annotationReader;
    private $typeMatrix;

    public function __construct(ApiAnnotationReader $annotationReader) {
        $this->annotationReader = $annotationReader;
        $this->typeMatrix = array(
            'int' => 1,
            'integer' => 1,
            'boolean' => true,
            'bool' => true,
            'string' => '...',
            '\date' => new \DateTime(),
            '\datetime' => new \DateTime(),
        );
    }

    /**
     * In charge to get an element populated with some example data.
     *
     * @param \Delr3ves\RestApiBundle\ApiObject\BaseApiObject $apiObject
     * @return \Delr3ves\RestApiBundle\ApiObject\BaseApiObject
     */
    public function populate($apiClass, $level=0) {
        $reflectionClass = new \ReflectionClass($apiClass);
        $apiObject = $reflectionClass->newInstanceArgs();
        foreach ($reflectionClass->getProperties() as $property) {
            $propertyName = $property->getName();
            $setterMethod = sprintf('set%s', ucfirst($propertyName));
            $value = $this->getValue($property, $level + 1);
            if ($reflectionClass->hasMethod($setterMethod)) {
                $apiObject->$setterMethod($value);
            }
        }
        return $apiObject;
    }

    public function getValue($property, $level) {
        $value = null;
        $embedded = $this->annotationReader->isEmbedded($property);
        $type = $this->annotationReader->getPropertyType($property);
        if (isset($this->typeMatrix[strtolower($type)])) {
            $value = $this->typeMatrix[strtolower($type)];
        } else if (!$embedded || $embedded && $level <= 2) {
            $value = $this->populate($type, $level);
        }

        if ($this->annotationReader->isCollection($property)) {
            $value = array($value);
        }
        return $value;
    }
}
