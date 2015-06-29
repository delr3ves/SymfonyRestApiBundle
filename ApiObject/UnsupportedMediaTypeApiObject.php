<?php
/**
 * 
 *
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */
namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\TypeHint;
use Delr3ves\RestApiBundle\Annotations\Collection;

/**
 * @XmlContainerTag(tagname="invalidformat")
 */
class UnsupportedMediaTypeApiObject extends BaseApiObject {

    /**
     * @var String
     * @TypeHint(hint="string")
     */
    protected $providedFormat;

    /**
     * @var array
     * @TypeHint(hint="string")
     * @Collection
     */
    protected $availableFormats;

    public function setAvailableFormats($availableFormats) {
        $this->availableFormats = $availableFormats;
    }

    public function getAvailableFormats() {
        return $this->availableFormats;
    }

    public function setProvidedFormat($providedFormat) {
        $this->providedFormat = $providedFormat;
    }

    public function getProvidedFormat() {
        return $this->providedFormat;
    }

}