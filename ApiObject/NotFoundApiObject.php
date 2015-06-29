<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\TypeHint;

/**
 * @XmlContainerTag(tagname="notFound")
 */
class NotFoundApiObject extends BaseApiObject {
    /**
     * @TypeHint(hint="string")
     */
    private $class;
    /**
     * @TypeHint(hint="string")
     */
    private $criteria;

    public function setClass($class) {
        $this->class = $class;
    }

    public function getClass() {
        return $this->class;
    }

    public function setCriteria($criteria) {
        $this->criteria = $criteria;
    }

    public function getCriteria() {
        return $this->criteria;
    }

}
