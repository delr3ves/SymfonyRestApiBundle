<?php
/**
 * In charge to test the XmlMarshaller and and get the parsed object to array
 * again to make the assertions in a easy way (compare strings is not flexible
 * enough).
 *
 *

 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\Integration\Marshalling;

use Delr3ves\RestApiBundle\Unmarshalling\JsonToArrayParser;
use SimpleXMLElement;
use Delr3ves\RestApiBundle\ApiObject\UserApiObject;
use Delr3ves\RestApiBundle\ApiObject\PersonalInfoApiObject;
use Delr3ves\RestApiBundle\Marshalling\RecursiveObjectToArray;
use Delr3ves\RestApiBundle\Tests\ObjectBuilder\UserApiObjectBuilder;
use Delr3ves\RestApiBundle\Marshalling\XmlMarshaller;
use Delr3ves\RestApiBundle\Unmarshalling\XmlToArrayParser;
use Delr3ves\RestApiBundle\Tests\Resources\TestResourceUtil;
use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;
use Delr3ves\RestApiBundle\Marshalling\EmbeddedPropertiesUtils;

class XmlMarshallerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RecursiveObjectToArray
     */
    protected $xmlMarshaller;


    public function setUp() {
        $apiAnnotationReader = new ApiAnnotationReader();
        $embbededPropertiesUtils = new EmbeddedPropertiesUtils($apiAnnotationReader);
        $this->xmlMarshaller = new XmlMarshaller($apiAnnotationReader, $embbededPropertiesUtils);
    }

    public static function getXmlProvider() {
        $userApiObjectBuilder = new UserApiObjectBuilder();

        return array(
            array($userApiObjectBuilder->createDefaultUserWithPersonalInfo(),
                'XmlObjects/UserWithNoBuddiesAndPersonalInfo.xml', array('personalInfo')),
            array($userApiObjectBuilder->createDefaultUserWithBuddies(1),
                'XmlObjects/UserWithOneBuddy.xml', array('buddies')),
        );
    }
    /**
     * @dataProvider getXmlProvider
     */
    public function testMarshallObject($object, $resultFile, $embedded) {
        $objectAsXml = new SimpleXMLElement(
            $this->xmlMarshaller->marshall($object, $embedded));
        $expectedXml = new SimpleXMLElement(
            TestResourceUtil::readResource($resultFile));

        $this->assertThat($objectAsXml, $this->equalTo($expectedXml));
    }

}
