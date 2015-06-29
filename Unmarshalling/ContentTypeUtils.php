<?php
/**
 * In charge to un-marshall a string formatted object into a dto object.
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

class ContentTypeUtils {

    const JSON_FORMAT = 'application/json';
    const XML_FORMAT = 'application/xml';
    const SIMPLE_JSON_FORMAT = 'json';
    const SIMPLE_XML_FORMAT = 'xml';


    public function normalize($format) {
        $normalizedFormatsMatrix = array(
            self::JSON_FORMAT => self::JSON_FORMAT,
            self::SIMPLE_JSON_FORMAT => self::JSON_FORMAT,
            self::XML_FORMAT =>  self::XML_FORMAT,
            self::SIMPLE_XML_FORMAT => self::XML_FORMAT,
        );

        if (isset($normalizedFormatsMatrix[$format])) {
            return $normalizedFormatsMatrix[$format];
        } else {
            throw new FormatNotSupportedException($format, $normalizedFormatsMatrix);
        }
    }

    /**
     * Get the current
     * @param $accept
     * @return mixed
     * @throws FormatNotSupportedException
     */
    public function findAcceptType($accept) {
        $normalizedFormatsMatrix = array(
            '*/*' => self::JSON_FORMAT,
            'application/*' => self::JSON_FORMAT,
            self::JSON_FORMAT => self::JSON_FORMAT,
            self::SIMPLE_JSON_FORMAT => self::JSON_FORMAT,
            self::XML_FORMAT =>  self::XML_FORMAT,
            self::SIMPLE_XML_FORMAT => self::XML_FORMAT,
        );
        $acceptList = explode(',' ,$accept);
        foreach ($acceptList as $contentType) {
            $contentType = $this->extractType(trim($contentType));
            if (isset($normalizedFormatsMatrix[$contentType])) {
                return $normalizedFormatsMatrix[$contentType];
            }
        }
        throw new FormatNotSupportedException($accept, $normalizedFormatsMatrix);
    }

    /**
     * Get the type part form accept type (for example application/xml;q=0.8 will
     * return application/xml
     */
    private function extractType($richContentType) {
        $acceptList = explode(';' ,$richContentType);
        return $acceptList[0];
    }

}
