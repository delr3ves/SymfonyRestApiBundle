<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\TypeHint;

/**
 * @XmlContainerTag(tagname="unprocessable")
 */
class UnprocessableEntityApiObject extends BaseApiObject {
    /**
     * @TypeHint(hint="string")
     */
    private $format;
    /**
     * @TypeHint(hint="string")
     */
    private $payload;
    /**
     * @TypeHint(hint="string")
     */
    private $schema;

    public function setFormat($format) {
        $this->format = $format;
    }

    public function getFormat() {
        return $this->format;
    }

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    public function getPayload() {
        return $this->payload;
    }

    public function setSchema($schema) {
        $this->schema = $schema;
    }

    public function getSchema() {
        return $this->schema;
    }



}
