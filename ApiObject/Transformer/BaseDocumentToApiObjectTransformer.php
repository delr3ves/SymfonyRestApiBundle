<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject\Transformer;

abstract class BaseDocumentToApiObjectTransformer implements  DocumentToApiObjectTransformer {
    /**
     * Base implementation for toDocument method
     * @param      $apiObject
     * @param null $document
     *
     * @return null|object
     */
    public function toDocument($apiObject, $document = null) {
        if (!$document) {
            $reflectionClass = new \ReflectionClass($this->getDocumentClass());
            $document = $reflectionClass->newInstanceArgs();
        }
        $this->exchangeDirectFields($apiObject, $document, $this->getToDocumentFields());

        return $document;
    }

    /**
     * Base implementation for toApiObject method
     * @param      $apiObject
     * @param null $document
     *
     * @return null|object
     */
    public function toApiObject($document, $apiObject = null, $embeddeds=array()) {
        if (!$apiObject) {
            $reflectionClass = new \ReflectionClass($this->getApiObjectClass());
            $apiObject = $reflectionClass->newInstanceArgs();
        }
        $this->exchangeDirectFields($document, $apiObject, $this->getToApiObjectFields());
        $this->addEmbeddeds($document, $apiObject, $embeddeds);
        return $apiObject;

    }

    public function toPaginatedListApiObject($documentList, $limit, $offset,
                                             $paginatedList = null, $embedded=array()) {
        if (!$paginatedList && $this->getPaginatedListApiObjectClass()) {
            $reflectionClass = new \ReflectionClass($this->getPaginatedListApiObjectClass());
            $paginatedList = $reflectionClass->newInstanceArgs();
        }
        $data = $documentList['data'];
        $size = $documentList['size'];
        $collection = array();
        foreach($data as $document) {
            $collection[] = $this->toApiObject($document, null, $embedded);
        }
        $paginatedList->setLimit($limit);
        $paginatedList->setOffset($offset);
        $paginatedList->setSize($size);
        $paginatedList->setData($collection);
        return $paginatedList;
    }

    protected function exchangeDirectFields($source, $target, $fields) {
        foreach ($fields as $fieldName) {
            $setter = 'set'.$fieldName;
            $getter = 'get'.$fieldName;
            $target->$setter($source->$getter());
        }
        return $target;
    }

    protected function addEmbeddeds($document, $apiObject, $embeddeds) {
        $embededMatrix = $this->getEmbeddedMethods();
        foreach($embeddeds as $embedded) {
            if (isset($embededMatrix[$embedded])) {
                $methodName = $embededMatrix[$embedded];
                $this->$methodName($document, $apiObject);
            }
        }
    }


    /**
     * Create an array with the method to call to get the embedded information.
     * The array will have the format {
     *  "embeddedName" => "methodToCall"
     * }
     * @return array
     */
    public function getEmbeddedMethods() {
        return array();
    }

    /**
     * Return the list of fieldname (capitalized) that are directly passed from
     * one object to another.
     * @return Array
     */
    public function getToDocumentFields() {
        return array();
    }

    /**
     * Return the list of fieldname (capitalized) that are directly passed from
     * one object to another.
     * @return Array
     */
    public function getToApiObjectFields() {
        return array();
    }


    /**
     * the api object class
     * @return string
     */
    public abstract function getApiObjectClass();
    /**
     * the document class
     * @return string
     */
    public abstract function getDocumentClass();

    /**
     * the paginated list api object class
     * @return string
     */
    public abstract function getPaginatedListApiObjectClass();
}
