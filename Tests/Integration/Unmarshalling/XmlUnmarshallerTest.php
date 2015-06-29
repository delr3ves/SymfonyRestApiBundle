<?php
/**
 * Test the correct behaviour of the XML unmarshallier.

 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\Integration\Unmarshalling;

use Delr3ves\RestApiBundle\Unmarshalling\XmlUnmarshaller;
use Delr3ves\RestApiBundle\Tests\Resources\TestResourceUtil;
use Delr3ves\RestApiBundle\Tests\ObjectBuilder\UserApiObjectBuilder;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class XmlUnmarshallerTest extends \PHPUnit_Framework_TestCase{

    const USER_API_OBJECT_CLASS = "Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject";
    /**
     * @var XmlUnmarshaller
     */
    private $xmlUnmarshaller;

    /**
     * @var UserApiObjectBuilder
     */
    private $userApiObjectBuilder;

    public function setUp() {
        $this->userApiObjectBuilder = new UserApiObjectBuilder();
        $this->xmlUnmarshaller = new XmlUnmarshaller(new ApiAnnotationReader());
    }


    /**
     * @param $xmlString
     * @param $classname
     * @param $expectedObject
     * @dataProvider xmlUnmarshallerProvider
     */
    public function testUnmarshaller($xmlString, $classname, $expectedObject) {
        $unmarshalledObject = $this->xmlUnmarshaller->unmarshall($xmlString, $classname);
        $this->assertThat($unmarshalledObject, $this->equalTo($expectedObject));
    }

    /**
     * Provides a set data to test the unmarshalling
     * @static
     *
     */
    public static function xmlUnmarshallerProvider() {
        $userApiObjectBuilder = new UserApiObjectBuilder();

        return array(
            self::getDataForUserWithNoEmbedded($userApiObjectBuilder),
            self::getDataForUserWithPersonalInfo($userApiObjectBuilder),
            self::getDataForUserWithTwoBuddies($userApiObjectBuilder),
            self::getDataForUserWithOneBuddy($userApiObjectBuilder),
            self::getDataForUserCollectionWithBuddies($userApiObjectBuilder),
            self::getDataForUserCollectionWithOneUser($userApiObjectBuilder),
            self::getDataForEmptyUserCollection(),
            self::getDataForEmptyUser(),

        );
    }

    private static function getDataForUserWithNoEmbedded(
            UserApiObjectBuilder $userApiObjectBuilder) {
        return array(TestResourceUtil::readResource('XmlObjects/UserWithNoEmbedded.xml'),
            self::USER_API_OBJECT_CLASS,
            $userApiObjectBuilder->createDefaultUser()
        );
    }

    private static function getDataForUserWithPersonalInfo(
            UserApiObjectBuilder $userApiObjectBuilder) {
        return array(TestResourceUtil::readResource('XmlObjects/UserWithNoBuddiesAndPersonalInfo.xml'),
            self::USER_API_OBJECT_CLASS,
            $userApiObjectBuilder->createDefaultUserWithPersonalInfo()
        );
    }

    private static function getDataForUserWithTwoBuddies(
        UserApiObjectBuilder $userApiObjectBuilder) {
        return array(TestResourceUtil::readResource('XmlObjects/UserWithTwoBuddies.xml'),
            self::USER_API_OBJECT_CLASS,
            $userApiObjectBuilder->createDefaultUserWithBuddies(2)
        );
    }

    private static function getDataForUserWithOneBuddy(
        UserApiObjectBuilder $userApiObjectBuilder) {
        return array(TestResourceUtil::readResource('XmlObjects/UserWithOneBuddy.xml'),
            self::USER_API_OBJECT_CLASS,
            $userApiObjectBuilder->createDefaultUserWithBuddies(1)
        );
    }

    private static function getDataForUserCollectionWithBuddies(
        UserApiObjectBuilder $userApiObjectBuilder) {
        $user = $userApiObjectBuilder->createDefaultUserWithBuddies(2);
        $users = array($user, $user);
        return array(TestResourceUtil::readResource('XmlObjects/UserCollection.xml'),
            self::USER_API_OBJECT_CLASS, $users
        );
    }

    private static function getDataForUserCollectionWithOneUser(
        UserApiObjectBuilder $userApiObjectBuilder) {
        $user = $userApiObjectBuilder->createDefaultUserWithPersonalInfo();
        $users = array($user);
        return array(TestResourceUtil::readResource('XmlObjects/UserCollectionWithOneUser.xml'),
            self::USER_API_OBJECT_CLASS, $users
        );
    }

    private static function getDataForEmptyUserCollection() {
        return array('<users/>', self::USER_API_OBJECT_CLASS, null);
    }
    private static function getDataForEmptyUser() {
        return array('<user/>', self::USER_API_OBJECT_CLASS, null);
    }
}
