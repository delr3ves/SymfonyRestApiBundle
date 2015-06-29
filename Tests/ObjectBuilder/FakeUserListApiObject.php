<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\Tests\ObjectBuilder;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\Embedded;
use Delr3ves\RestApiBundle\Annotations\TypeHint;
use Delr3ves\RestApiBundle\Annotations\Collection;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;

/**
 * @XmlContainerTag(tagname="users")
 */
class FakeUserListApiObject extends BaseApiObject {

    /**
     * @TypeHint(hint="Delr3ves\RestApiBundle\ApiObject\PaginationInfoApiObject")
     */
    private $pagination;

    /**
     * @Collection
     * @TypeHint(hint="Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject")
     */
    private $users;

    public function setPagination($pagination) {
        $this->pagination = $pagination;
    }

    public function getPagination() {
        return $this->pagination;
    }

    public function setUsers($users) {
        $this->users = $users;
    }

    public function getUsers() {
        return $this->users;
    }


}
