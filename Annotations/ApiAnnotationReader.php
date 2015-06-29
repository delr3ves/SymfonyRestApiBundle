<?php
/**
 * Provides the methods to get information about the API annotations.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Annotations;

class ApiAnnotationReader {

    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    private $annotationReader;

    public function __construct() {
        $this->annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();
    }

    /**
     * Check if the field has the \@embedded tag
     * @param ReflectionProperty $property the field
     * @return bool
     */
    public function isEmbedded(\ReflectionProperty $property) {
        return $this->hasTag($property, 'Embedded');
    }

    /**
     * Check if the field has the \@required tag
     * @param ReflectionProperty $property the field
     * @return bool
     */
    public function isRequired(\ReflectionProperty $property) {
        return $this->hasTag($property, 'Required');
    }

    /**
     * Check if the field has the \@readOnly tag
     * @param ReflectionProperty $property the field
     * @return bool
     */
    public function isReadOnly(\ReflectionProperty $property) {
        return $this->hasTag($property, 'ReadOnly');
    }

    /**
     * Check if the field has the \@collection tag
     * @param ReflectionProperty $property the field
     * @return bool
     */
    public function isCollection(\ReflectionProperty $property) {
        return $this->hasTag($property, 'Collection');
    }

    /**
     * Check if the field has the \@embedded tag
     * @param ReflectionProperty $property the field
     * @return bool
     */
    public function getPropertyType(\ReflectionProperty $property) {
        return $this->annotationReader->getPropertyAnnotation($property,
            'Delr3ves\RestApiBundle\Annotations\TypeHint')->hint['hint'];
    }


    /**
     * Get the name of the main container tag, for first element, in case of xml rendering.
     * It will get the data from the annotation @XmlContainerTag or will return 'value'
     * if the annotation does not exists.
     * @param $object
     * @return string
     */
    public function getXmlContainerTagForFirstElement($object) {
        if (is_array($object) && count($object) > 0) {
            foreach ($object as $element) {
                $containerTag = $this->getXmlContainerTagForFirstElement($element);
                $containerTag = $this->pluralizeTag($containerTag);
                return $containerTag;
            }
        } else {
            return $this->getXmlContainerTag($object);
        }
    }

    /**
     * Find the name of the container tag when rendering an object in xml inside
     * a list.
     * @param $element
     * @return string
     */
    public function getXmlContainerTag($element) {
        $containerTag = 'value';
        if (is_a($element, 'Delr3ves\RestApiBundle\ApiObject\BaseApiObject')) {
            $classname = get_class($element);
            $reflectionClass = new \ReflectionClass($classname);
            $annotation = $this->annotationReader->getClassAnnotation($reflectionClass,
                'Delr3ves\RestApiBundle\Annotations\XmlContainerTag');
            $containerTag = $annotation->tagname['tagname'];
        }
        return $containerTag;
    }

    public function pluralizeTag($tag) {
        return $tag . 's';
    }


    public function hasTag($property, $tagName) {
        return $this->annotationReader->getPropertyAnnotation($property,
            'Delr3ves\RestApiBundle\Annotations\\' . $tagName) != null;
    }

    /**
     * Find the name of the container tag when rendering an object in xml inside
     * a list.
     * @param $element
     * @return string
     */
    public function getXmlContainerTagByClassname($classname) {
        try {
            $reflectionClass = new \ReflectionClass($classname);
            $annotation = $this->annotationReader->getClassAnnotation($reflectionClass,
                'Delr3ves\RestApiBundle\Annotations\XmlContainerTag');
            $containerTag = $annotation->tagname['tagname'];
        } catch (\Exception $e) {
            $containerTag = 'value';
        }
        return $containerTag;
    }
}

