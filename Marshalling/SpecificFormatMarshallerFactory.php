<?php
/**
 * Will create the proper marshaller according to the desired output format.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\Unmarshalling\ContentTypeUtils;

class SpecificFormatMarshallerFactory {

    /**
     * Associative array containing the supported format pointing to the proper marshaller.
     * @var array
     */
    protected $marshallerMatrix;
    /**
     * @var ContentTypeUtils
     */
    protected $contentTypeUtils;

    public function __construct(ContentTypeUtils $contentTypeUtils,
                                SpecificFormatMarshaller $xmlMarshaller,
                                SpecificFormatMarshaller $jsonMarshaller) {

        $this->contentTypeUtils = $contentTypeUtils;
        $this->marshallerMatrix = array(
            ContentTypeUtils::XML_FORMAT => $xmlMarshaller,
            ContentTypeUtils::JSON_FORMAT => $jsonMarshaller,
        );
    }


    /**
     * @return ToArrayParser containing the proper parser for the givent format.
     */
    public function getMarshaller($format) {
        $normalizedFormat = $this->contentTypeUtils->findAcceptType($format);
        return $this->marshallerMatrix[$normalizedFormat];
    }

}
