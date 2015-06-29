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
 * @XmlContainerTag(tagname="personalInfo")
 */
class FakePersonalInfoApiObject extends BaseApiObject{

    /**
     * @TypeHint(hint="string")
     */
    private $email;
    /**
     * @TypeHint(hint="string")
     */
    private $gender;
    /**
     * @TypeHint(hint="\DateTime")
     */
    private $signDate;
    /**
     * @TypeHint(hint="string")
     */
    private $location;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setSignDate($signDate) {
        $this->signDate = $signDate;
    }

    public function getSignDate() {
        return $this->signDate;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }


}
