<?php
/**
 * In charge to return the proper unmarshaller for the given format.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

class SpecificFormatUnmarshallerFactory {

    /**
     * Associative array containing the supported format pointing to the proper parser.
     * @var array
     */
    protected $parserMatrix;
    /**
     * @var ContentTypeUtils
     */
    protected $contentTypeUtils;

    public function __construct(ContentTypeUtils $contentTypeUtils,
                                SpecificFormatUnmarshaller $xmlUnmarshaller,
                                SpecificFormatUnmarshaller $jsonUnmarshaller) {
        $this->contentTypeUtils = $contentTypeUtils;
        $this->parserMatrix = array(
            ContentTypeUtils::XML_FORMAT => $xmlUnmarshaller,
            ContentTypeUtils::JSON_FORMAT => $jsonUnmarshaller,
        );
    }


    /**
     * @return SpecificFormatUnmarshaller containing the proper parser for the givent format.
     */
    public function getUnmarshaller($format) {
        $normalizedFormat = $this->contentTypeUtils->normalize($format);
        return $this->parserMatrix[$normalizedFormat];
    }

}
