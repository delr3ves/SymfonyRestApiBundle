<?php
/**
 * Defines the common information every paginated list should contains.
 *
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\TypeHint;

abstract class BasePaginatedApiObject extends BaseApiObject {

    /**
     * @var int
     * @TypeHint(hint="integer")
     */
    protected $limit;

    /**
     * @var int
     * @TypeHint(hint="integer")
     */
    protected $offset;

    /**
     * @var int
     * @TypeHint(hint="integer")
     */
    protected $size;

    /**
     * @TypeHint(hint="boolean")
     */
    protected $hasMorePages;

    public function setLimit($limit) {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getLimit() {
        return (int)$this->limit;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return (int)$this->offset;
    }

    /**
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return (int)$this->size;
    }


    public function getHasMorePages() {
        return $this->offset + $this->limit < $this->size;
    }

    public function setHasMorePages($hasMorePage) {
        return $this->hasMorePages = $hasMorePage;
    }

    public function setData($comments) {
        $this->data = $comments;
    }

    public function getData() {
        return $this->data;
    }
}
