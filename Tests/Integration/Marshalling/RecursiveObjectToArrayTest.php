<?php

namespace Delr3ves\RestApiBundle\Tests\Unit\Unmarshalling;

use Delr3ves\RestApiBundle\Unmarshalling\JsonToArrayParser;
use Delr3ves\RestApiBundle\ApiObject\UserApiObject;
use Delr3ves\RestApiBundle\ApiObject\PersonalInfoApiObject;
use Delr3ves\RestApiBundle\Marshalling\RecursiveObjectToArray;
use Delr3ves\RestApiBundle\Tests\ObjectBuilder\UserApiObjectBuilder;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;
use Delr3ves\RestApiBundle\Marshalling\EmbeddedPropertiesUtils;

class RecursiveObjectToArrayTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RecursiveObjectToArray
     */
    protected $objectToArray;

    /**
     * @var UserApiObjectBuilder
     */
    protected $userApiObjectBuilder;

    public function setUp() {
        $apiAnnotationReader = new ApiAnnotationReader();
        $embbededPropertiesUtils = new EmbeddedPropertiesUtils($apiAnnotationReader);

        $this->objectToArray = new RecursiveObjectToArray($embbededPropertiesUtils);
        $this->userApiObjectBuilder = new UserApiObjectBuilder();
    }

    public function testParseUserWithNoList() {
        $user = $this->userApiObjectBuilder->createDefaultUserWithPersonalInfo();

        $expectedArray = array('username' => 'irrelevantUsername',
            'locale' => 'es',
            'personalInfo' => array('email' => 'email',
                'gender' => 'gender',
                'signDate' => $user->getPersonalInfo()->getSignDate()->format('c') ,
                'location' => null,),
            'firstname' => 'irrelevantFirstname',
            'lastname' => 'irrelevantLastname',
            'avatar' => null,
            );
        $objectAsArray = $this->objectToArray->toArray($user, array('personalInfo'));
        $this->assertThat($objectAsArray, $this->equalTo($expectedArray));
    }


    public function testParseUserWithList() {
        $user = $this->userApiObjectBuilder->createDefaultUserWithBuddies(1);
        $expectedArray = array('username' => 'irrelevantUsername',
            'locale' => 'es',
            'firstname' => 'irrelevantFirstname',
            'lastname' => 'irrelevantLastname',
            'avatar' => null,
        );

        $buddies = array(
            'pagination' => array(
                'limit' => 1,
                'offset' => 0,
                'hasMorePages' => False,
                'totalSize' => 1,
                'page' => null,
            ),
            'users' => array($expectedArray),
        );
        $expectedArray['buddies'] = $buddies;

        $objectAsArray = $this->objectToArray->toArray($user, array('buddies'));
        $this->assertThat($objectAsArray, $this->equalTo($expectedArray));
    }

}
