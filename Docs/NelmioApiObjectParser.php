<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\Docs;

use Nelmio\ApiDocBundle\Parser\ParserInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;
use ReflectionProperty;

class NelmioApiObjectParser implements ParserInterface {

    /**
     * @var \Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader
     */
    private $annotationReader;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;

    public function __construct(ApiAnnotationReader $annotationReader,
                                Router $router) {
        $this->annotationReader = $annotationReader;
        $this->router = $router;
    }

    /**
     * Return true/false whether this class supports parsing the given class.
     *
     * @param  string  $item The string type of input to parse.
     *
     * @return boolean
     */
    public function supports(array $item) {
        try {
            $reflectionClass = new \ReflectionClass($item['class']);
            return $reflectionClass->isSubclassOf('Delr3ves\RestApiBundle\ApiObject\BaseApiObject');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns an array of class property metadata where each item is a key (the property name) and
     * an array of data with the following keys:
     *  - dataType          string
     *  - required          boolean
     *  - description       string
     *  - readonly          boolean
     *  - children          (optional) array of nested property names mapped to arrays
     *                      in the format described here
     *
     * @param  string $item The string type of input to parse.
     * @return array
     */
    public function parse(array $item) {
        $fields = array();
        $class = $item['class'];
        $reflectionClass = new \ReflectionClass($class);
        $fields['RESOURCE'] = array(
            'description' => $this->processComment(
                $reflectionClass->getDocComment(), $class),
            'dataType' => $class,
            'readonly' => false,
            'required' => true,
        );

        foreach ($reflectionClass->getProperties() as $property) {
            $fields[$property->getName()] = $this->extractFieldInfo($property);
        }
        return $fields;
    }

    private function extractFieldInfo(\ReflectionProperty $field) {
        return array(
            'description' => $this->processComment($field->getDocComment(),
                $this->annotationReader->getPropertyType($field)),
            'dataType' => $this->annotationReader->getPropertyType($field),
            'readonly' => $this->annotationReader->isReadOnly($field),
            'required' => $this->annotationReader->isRequired($field),
        );
    }

    private function processComment($comment, $type) {
        $comment = preg_replace('/\*/', '', $comment);
        $comment = preg_replace('/\//', '', $comment);
        $comment = preg_replace('/@[^\n]*/', '', $comment);
        $comment .= implode(', ', $this->getLinks($type));
        return $comment;
    }

    private function getLinks($type) {
        $links = array();
        if (class_exists($type)) {
            foreach(array('json', 'xml') as $format) {
                $route = $this->router->generate('rest_api_populate_api_object');
                $mask = '<a target="blank" href="%s?class=%s&Accept=%s">%s example</a>';
                $links[] = sprintf($mask, $route, $type, $format, $format);
            }
        }
        return $links;
    }
}