<?php
namespace Delr3ves\RestApiBundle\Tests\Unit\Unmarshalling;

use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;
use Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject;

class ApiAnnotationReaderTest extends \PHPUnit_Framework_TestCase {

    const USER_CLASSNAME = 'Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject';
    const PAGINATED_USER_CLASSNAME = 'Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserListApiObject';
    const PERSONAL_INFO_CLASSNAME = 'Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakePersonalInfoApiObject';

    /**
     * @var ApiAnnotationReader
     */
    protected $apiAnnotationReader;

    public function setUp() {
        $this->apiAnnotationReader = new ApiAnnotationReader();
    }


    public static function embeddedProvider() {
        return array(
            array('personalInfo', True),
            array('username', False),
            array('firstname', False),
            array('avatar', False),
            array('lastname', False),
            array('buddies', True),
        );
    }
    /**
     * @dataProvider embeddedProvider
     */
    public function testFieldIsEmbedded($property, $expectedEmbedded) {
        $reflectionClass = new \ReflectionClass(self::USER_CLASSNAME);
        $embeddedProperty = $reflectionClass->getProperty($property);
        $isEmbedded = $this->apiAnnotationReader->isEmbedded($embeddedProperty);
        $this->assertThat($expectedEmbedded, $this->equalTo($isEmbedded));
    }


    public static function collectionProvider() {
        return array(
            array('personalInfo', False),
            array('username', False),
            array('firstname', False),
            array('lastname', False),
            array('buddies', False),
        );
    }
    /**
     * @dataProvider collectionProvider
     */
    public function testFieldIsCollection($property, $expectedEmbedded) {
        $reflectionClass = new \ReflectionClass(self::USER_CLASSNAME);
        $embeddedProperty = $reflectionClass->getProperty($property);
        $isEmbedded = $this->apiAnnotationReader->isCollection($embeddedProperty);
        $this->assertThat($expectedEmbedded, $this->equalTo($isEmbedded));
    }


    public static function xmlContainerTagProvider() {
        $user = new FakeUserApiObject();
        return array(
            array($user, 'user'),
            array('blahblahblah', 'value'),
            array(array($user), 'value'),
            array(array('blahblahblah'), 'value'),
        );
    }
    /**
     * @dataProvider xmlContainerTagProvider
     */
    public function testGetContainerTag($object, $containerTag) {
        $xmlContainerTag = $this->apiAnnotationReader->getXmlContainerTag($object);
        $this->assertThat($containerTag, $this->equalTo($xmlContainerTag));
    }

    public static function xmlContainerTagForFirstElementProvider() {
        $user = new FakeUserApiObject();
        return array(
            array($user, 'user'),
            array('blahblahblah', 'value'),
            array(array($user), 'users'),
            array(array('blahblahblah'), 'values'),
        );
    }
    /**
     * @dataProvider xmlContainerTagForFirstElementProvider
     */
    public function testGetContainerForFirstTag($object, $containerTag) {
        $xmlContainerTag = $this->apiAnnotationReader->getXmlContainerTagForFirstElement($object);
        $this->assertThat($containerTag, $this->equalTo($xmlContainerTag));
    }

    public static function typeProvider() {
        return array(
            array(self::USER_CLASSNAME,'personalInfo', self::PERSONAL_INFO_CLASSNAME),
            array(self::USER_CLASSNAME,'username', 'string'),
            array(self::USER_CLASSNAME,'buddies', self::PAGINATED_USER_CLASSNAME),
            array(self::PERSONAL_INFO_CLASSNAME,'signDate', '\DateTime'),
        );
    }
    /**
     * @dataProvider typeProvider
     */
    public function testGetPropertyType($className, $property, $type) {
        $reflectionClass = new \ReflectionClass($className);
        $embeddedProperty = $reflectionClass->getProperty($property);
        $propertyType = $this->apiAnnotationReader->getPropertyType($embeddedProperty);
        $this->assertThat($type, $this->equalTo($propertyType));

    }
}
