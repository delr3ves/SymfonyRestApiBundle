<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;

/**
 * @XmlContainerTag(tagname="forbidden")
 */
class ForbiddenApiObject extends BaseApiObject {

    private $reason;

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function getReason() {
        return $this->reason;
    }

}
