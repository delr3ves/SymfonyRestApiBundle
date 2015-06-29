<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\Collection;

/**
 * @XmlContainerTag(tagname="violations")
 */
class ViolationsApiObject extends BaseApiObject {

    /**
     * @Collection
     */
    private $violations;

    public function setViolations($violations) {
        $this->violations = $violations;
    }

    public function getViolations() {
        return $this->violations;
    }

}
