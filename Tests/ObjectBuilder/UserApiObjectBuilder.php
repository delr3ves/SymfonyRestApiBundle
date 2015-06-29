<?php
/**
 *

 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\ObjectBuilder;

use Delr3ves\RestApiBundle\ApiObject\PaginationInfoApiObject;

class UserApiObjectBuilder {

    public function createDefaultUser() {
        $user = new FakeUserApiObject();
        $user->setUsername('irrelevantUsername');
        $user->setFirstname('irrelevantFirstname');
        $user->setLocale('es');
        $user->setLastname('irrelevantLastname');
        return $user;
    }

    /**
     * @return FakeUserApiObject
     */
    public function createDefaultUserWithPersonalInfo() {
        $user = $this->createDefaultUser();
        $personalInfo = new FakePersonalInfoApiObject();
        $personalInfo->setEmail('email');
        $personalInfo->setGender('gender');
        $personalInfo->setSignDate(new \DateTime('23-05-1983T00:00:00'));

        $user->setPersonalInfo($personalInfo);

        return $user;
    }

    public function createDefaultUserWithBuddies($buddiesNumber = 2) {
        $user = $this->createDefaultUser();
        $buddies = array();
        for ($i=0; $i<$buddiesNumber; $i++) {
            $buddies[] = $this->createDefaultUser();
        }
        $paginatedUser = new FakeUserListApiObject();
        $paginatedUser->setUsers($buddies);

        $paginationInfo = new PaginationInfoApiObject();
        $paginationInfo->setLimit($buddiesNumber);
        $paginationInfo->setOffset(0);
        $paginationInfo->setHasMorePages(False);
        $paginationInfo->setTotalSize($buddiesNumber);
        $paginatedUser->setPagination($paginationInfo);

        $user->setBuddies($paginatedUser);
        return $user;

    }
}
