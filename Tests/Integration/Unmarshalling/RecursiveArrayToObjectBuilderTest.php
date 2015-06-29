<?php
/**
 * Test the generic unmarshaller.

 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\Integration\Unmarshalling;

use Delr3ves\RestApiBundle\Unmarshalling\RecursiveArrayToObjectBuilder;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class RecursiveArrayToObjectBuilderTest extends \PHPUnit_Framework_TestCase {

    private $marshaller;

    public function setUp() {
        $this->marshaller = new RecursiveArrayToObjectBuilder(new ApiAnnotationReader());
    }


    public function testGetValueTypeShouldReturnBasic() {
        $type = $this->marshaller->getValueType('basicType');
        $this->assertThat($type, $this->equalTo(RecursiveArrayToObjectBuilder::BASIC_TYPE));
        $type = $this->marshaller->getValueType(1923);
        $this->assertThat($type, $this->equalTo(RecursiveArrayToObjectBuilder::BASIC_TYPE));
        $type = $this->marshaller->getValueType(true);
        $this->assertThat($type, $this->equalTo(RecursiveArrayToObjectBuilder::BASIC_TYPE));
    }

    public function testGetValueTypeShouldReturnObject() {
        $type = $this->marshaller->getValueType(array('key1' => 'value1',
            'key2' => 'value2'));
        $this->assertThat($type, $this->equalTo(RecursiveArrayToObjectBuilder::OBJECT_TYPE));

    }

    public function testGetValueTypeShouldReturnArray() {
        $type = $this->marshaller->getValueType(array(1, 2, 3));
        $this->assertThat($type, $this->equalTo(RecursiveArrayToObjectBuilder::LIST_TYPE));
    }


    public function testParseArrayWithoutParentTagsShouldReturnUserApiObject() {
        $userAsArray = array('username' => 'irrelevantUsername',
            'locale' => 'es',
            'personalInfo' => array('email' => 'email',
                'gender' => 'gender',
                'signDate' => '23-05-1983T00:00:00'));
        $userApiObject = $this->marshaller->build($userAsArray, 'Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject');
        $this->assertThat(get_class(
            $userApiObject), $this->equalTo('Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject'));
        $this->assertThat(get_class(
            $userApiObject->getPersonalInfo()), $this->equalTo('Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakePersonalInfoApiObject'));
        $this->assertThat(get_class(
            $userApiObject->getPersonalInfo()->getSignDate()), $this->equalTo('DateTime'));
    }


    public function testParseArrayWithParentTagsShouldReturnUserApiObject() {
        $userAsArray = array(
            'username' => 'irrelevantUsername',
            'locale' => 'es',
            'personalInfo' => array(
                'email' => 'email',
                'gender' => 'gender',
                'signDate' => '23-05-1983T00:00:00'),
        );

        $userApiObject = $this->marshaller->build($userAsArray, 'Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject');

        $this->assertThat(get_class(
            $userApiObject), $this->equalTo('Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakeUserApiObject'));
        $this->assertThat(get_class(
            $userApiObject->getPersonalInfo()), $this->equalTo('Delr3ves\RestApiBundle\Tests\ObjectBuilder\FakePersonalInfoApiObject'));
        $this->assertThat(get_class(
            $userApiObject->getPersonalInfo()->getSignDate()), $this->equalTo('DateTime'));
    }
}
