<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\ApiObject;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\TypeHint;

/**
 * @XmlContainerTag(tagname="pagination")
 */
class PaginationInfoApiObject extends BaseApiObject {

    /**
     * @TypeHint(hint="integer")
     */
    private $limit;
    /**
     * @TypeHint(hint="integer")
     */
    private $offset;
    /**
     * @TypeHint(hint="integer")
     */
    private $page;
    /**
     * @TypeHint(hint="boolean")
     */
    private $hasMorePages;
    /**
     * @TypeHint(hint="integer")
     */
    private $totalSize;

    public function setHasMorePages($hasMorePages) {
        $this->hasMorePages = $hasMorePages;
    }

    public function getHasMorePages() {
        return $this->hasMorePages;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function setTotalSize($totalSize) {
        $this->totalSize = $totalSize;
    }

    public function getTotalSize() {
        return $this->totalSize;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function getPage() {
        return $this->page;
    }



}
