<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\Tests\ObjectBuilder;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;
use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\Embedded;
use Delr3ves\RestApiBundle\Annotations\TypeHint;

/**
 * @XmlContainerTag(tagname="user")
 */
class FakeUserApiObject extends BaseApiObject{

    /**
     * @TypeHint(hint="string")
     */
    private $username;
    /**
     * @TypeHint(hint="string")
     */
    private $firstname;
    /**
     * @TypeHint(hint="string")
     */
    private $lastname;
    /**
     * @TypeHint(hint="string")
     */
    private $locale;

    /**
     * @var FakePersonalInfoApiObject
     * @Embedded
     * @TypeHint(hint="Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakePersonalInfoApiObject")
     */
    private $personalInfo;

    /**
     * @Embedded
     * @TypeHint(hint="Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserListApiObject")
     */
    private $buddies;

    /**
     * @TypeHint(hint="Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserAvatarApiObject")
     */
    private $avatar;

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setBuddies($buddies) {
        $this->buddies = $buddies;
    }

    public function getBuddies() {
        return $this->buddies;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLocale($locale) {
        $this->locale = $locale;
    }

    public function getLocale() {
        return $this->locale;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPersonalInfo($personalInfo) {
        $this->personalInfo = $personalInfo;
    }

    public function getPersonalInfo() {
        return $this->personalInfo;
    }



}
