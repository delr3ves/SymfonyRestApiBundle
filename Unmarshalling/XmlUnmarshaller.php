<?php
/**
 * Reads a xml string and returns the PHP object representation according to the
 * specified class
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class XmlUnmarshaller implements SpecificFormatUnmarshaller {

    /**
     * Represents the basic information like string, integer, boolean, etc.
     */
    const BASIC_TYPE = 'basic';
    /**
     * Represents a complex object with fields.
     */
    const OBJECT_TYPE = 'object';
    /**
     * Represents a
     */

    const EMPTY_TYPE = 'empty';
    const ARRAY_TYPE = 'array';


    /**
     * @var \Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader
     */
    private $apiAnnotationReader;


    public function __construct(ApiAnnotationReader $apiAnnotationReader) {
        $this->apiAnnotationReader = $apiAnnotationReader;
    }

    /**
     * Generates an array containing the information represented in the xml with
     * the restictions bellow:
     *
     *  - The array won't contain the container tag in case of parent object,
     *    embedded objects of items in collections.
     *
     *  - A collection of elements of the same type will be represented like:
     * <fieldName>
     *    <itemTypeName>item1</itemTypeName>
     *    <itemTypeName>...</itemTypeName>
     *    <itemTypeName>itemN</itemTypeName>
     * </fieldName>
     *
     * @var contents the xml string with the object representation
     * @return array the object represented as an array.
     */
    public function unmarshall($contents, $classname) {
        $xmlObject = new \SimpleXMLElement($contents);
        $isList = $this->containsCollectionOfObjects(
                $xmlObject, $classname);
        return $this->parseXmlNode($xmlObject, $classname, $isList);
    }


    protected function parseXmlNode($xmlObject, $classname, $collectionExpected) {
        $nodeType = $this->getValueType($xmlObject, $collectionExpected);
        switch ($nodeType) {
            case self::BASIC_TYPE:
                return $this->processBasic($xmlObject, $classname);
            case self::OBJECT_TYPE:
                return $this->processObject($xmlObject, $classname);
            case self::EMPTY_TYPE:
                return null;
            case self::ARRAY_TYPE:
                return $this->processArray($xmlObject, $classname);
        }

    }


    protected function processObject($xmlObject, $classname) {
        $reflectionClass = new \ReflectionClass($classname);
        $object = $reflectionClass->newInstanceArgs();
        $xmlObjectAsArray = (array)$xmlObject;
        foreach ($xmlObjectAsArray as $key => $xmlNode) {
            if ($reflectionClass->hasProperty($key)) {
                $setterMethod = sprintf('set%s', ucfirst($key));
                $property = $reflectionClass->getProperty($key);
                $propertyClass = $this->apiAnnotationReader->getPropertyType($property);
                $isCollection = $this->apiAnnotationReader->isCollection($property);
                $value = $this->parseXmlNode($xmlNode, $propertyClass, $isCollection);
                if ($value) {
                    $object->$setterMethod($value);
                }
            }
        }
        return $object;
    }


    protected function processArray($array, $classname) {
        $result = array();
        foreach ($array as $element) {
            $result[] = $this->parseXmlNode($element, $classname, false);
        }
        return $result;
    }

    protected function processBasic($value, $className) {
        if (class_exists($className)) {
            $r = new \ReflectionClass($className);
            $result = $r->newInstanceArgs(array($value));
        } else {
            $result = $this->transformToBasicType($value, $className);
        }
        return $result;
    }

    private function transformToBasicType($value, $type) {
        switch ($type) {
            case 'integer':
                $result = (int) $value;
                break;
            case 'boolean':
                $result = 'true' == strtolower($value)?true:false;
                break;
            default:;
                $result = $value;
        }
        return $result;
    }

    /**
     * Decides the type of the data (basic type, object or list).
     * @param $value
     * @return string
     */
    private function getValueType($xmlNode, $expectedCollection) {
        $valueType = self::BASIC_TYPE;
        if ($expectedCollection) {
            $valueType = self::ARRAY_TYPE;
        }else if (is_object($xmlNode) && get_class($xmlNode) == 'SimpleXMLElement') {
            $valueType = self::OBJECT_TYPE;
            if ($this->isList($xmlNode)) {
                $valueType = self::ARRAY_TYPE;
            } else if ($this->isEmpty($xmlNode)) {
                $valueType = self::EMPTY_TYPE;
            }
        } else if (is_array($xmlNode)) {
            $valueType = self::ARRAY_TYPE;
        }
        return $valueType;
    }

    /**
     * SimpleXmlElement will parse the collections as
     *  {collectionName: itemTagContainer: [item1, item2, ..., itemN]}
     * but the "itemTagContainer" is useless for the transformed array so it
     * will check if the first children is an array.
     * @param $xmlNode
     * @return bool
     */
    private function isList($xmlNode) {
        $isList = false;
        $nodeAsArray = (array)$xmlNode;
        if (count($nodeAsArray) == 1) {
            $isList = is_array($this->getFirstElement($nodeAsArray));
        }
        return $isList;
    }

    /**
     * Retrieve the first element of an associative array.
     * @param $nodeAsArray the associative array.
     * @return mixed the first element
     */
    private function getFirstElement($nodeAsArray) {
        $keyList = array_keys($nodeAsArray);
        $key = $keyList[0];
        return $nodeAsArray[$key];
    }

    private function isEmpty($xmlNode) {
        return count($xmlNode) == 0;
    }

    private function containsCollectionOfObjects($simpleXmlElemnt, $classname) {
        $tag = $this->apiAnnotationReader->getXmlContainerTagByClassname($classname);
        $keys = array_keys((array)$simpleXmlElemnt);
        return count($keys) > 0 && $keys[0] == $tag;
    }
}
