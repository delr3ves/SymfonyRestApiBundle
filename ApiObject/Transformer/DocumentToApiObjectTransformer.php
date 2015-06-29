<?php
/**
 * Provides the common methods to transform Documents to Api-Objects and vice-versa
 *
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject\Transformer;

interface DocumentToApiObjectTransformer {

    /**
     * Base implementation for toDocument method
     * @param      $apiObject
     * @param null $document if null, a new document will be created, otherwise
     *  this method will update the fields.
     *
     * @return object the document
     */
    public function toDocument($apiObject, $document = null);

    /**
     * Base implementation for toApiObject method
     * @param      $document
     * @param null $apiObject if null, a new document will be created, otherwise
     *                        this method will update the fields.
     * @param $embeddeds array containing the name of the embeddeds to include
     *                    during the conversion.
     *
     * @return object the api object
     */
    public function toApiObject($document, $apiObject = null, $embeddeds=array());

    /**
     * Transform a set of documents in a paginated list of ApiObjects filling
     * the propper documents and also the pagination parameters like limit,
     * offset and total size.
     * @param $documentList
     * @param $limit
     * @param $offset
     * @param null $paginatedList
     * @param array $embedded
     * @return mixed
     */
    public function toPaginatedListApiObject($documentList, $limit, $offset,
                                             $paginatedList = null, $embedded=array());

}
