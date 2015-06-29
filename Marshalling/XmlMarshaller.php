<?php
/**
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;
use Delr3ves\RestApiBundle\Marshalling\EmbeddedPropertiesUtils;

class XmlMarshaller implements SpecificFormatMarshaller {


    private $embeddedPropertiesUtils;

    private $apiAnnotationReader;

    public function __construct(ApiAnnotationReader $apiAnnotationReader,
            EmbeddedPropertiesUtils $embeddedPropertiesUtils) {
        $this->embeddedPropertiesUtils = $embeddedPropertiesUtils;
        $this->apiAnnotationReader = $apiAnnotationReader;
    }

    /**
     * Marshall the given object to a XML string.
     * @see SpecificFormatMarshaller::marshall()
     */
    public function marshall($object, array $embedded = array()) {
        $xml = new \XmlWriter();
        $xml->openMemory();
        $xml->startDocument('1.0');
        $xml->setIndent(true);
        $xml->startElement($this->apiAnnotationReader
                    ->getXmlContainerTagForFirstElement($object));
        $this->toXml($xml, $object, $embedded);
        $xml->endElement();

        return $xml->outputMemory(true);
    }

    /**
     * Recursive function to dump the content of an object to an xml string.
     * @param XmlWriter $xml the xml writer to dump the content
     * @param $object the object to be marshalled
     * @param array $embedded the list of "embeded" fileds wich will take part of the dump
     * @param $deep the deep level to know if going to marshall a first level object or
     * a child (in this way we don't want to embedded the fields).
     */
    public function toXml(\XmlWriter $xml, $object, array $embedded, $deep = 1) {
        if (is_a($object, '\DateTime')) {
            $xml->text($object->format('Y-m-d\TH:i:s'));
        } else if(is_object($object)) {
            $this->processObject($xml, $object, $embedded, $deep);
        } else if(is_array($object)) { //it will work with list
            $this->proccessArray($xml, $object, $embedded, $deep);
        } else if (is_string($object) || is_numeric($object)) {
            $xml->text($object);
        }else if(is_bool($object)) {
            $text = ($object ? 'true' : 'false');
            $xml->text($text);
        }

    }


    /**
     * Dumps the data when the xml node is an object
     * @param XMLWriter $xml
     * @param $object
     * @param $embedded
     * @param $deep
     */
    private function processObject(\XMLWriter $xml, $object, array $embedded, $deep) {
        $classname = get_class($object);
        $reflectionClass = new \ReflectionClass($classname);

        foreach ($reflectionClass->getProperties() as $property) {
            if ($this->embeddedPropertiesUtils->haveToEmbedded(
                        $property, $embedded, $deep)) {

                $propertyName = $property->getName();
                $getterMethod = sprintf('get%s', ucfirst($propertyName));
                $xml->startElement($propertyName);
                $this->toXml($xml, $object->$getterMethod(), $embedded, $deep + 1); //now is not in level one.
                $xml->endElement();
            }
        }
    }

    /**
     * Dumps the data when the xml node is an array
     * @param XMLWriter $xml
     * @param $object
     * @param $embedded
     * @param $deep
     */
    private function proccessArray(\XMLWriter $xml, $object, array $embedded, $deep) {
        foreach ($object as $key => $element) {
            $tag = is_numeric($key)?$this->apiAnnotationReader->getXmlContainerTag($element):$key;
            $xml->startElement($tag);
            $this->toXml($xml,$element, $embedded, $deep);
            $xml->endElement();
        }
    }

}