<?php
namespace Delr3ves\RestApiBundle\Tests\Unit\Unmarshalling;

use Delr3ves\RestApiBundle\Unmarshalling\ContentTypeUtils;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;

class ContentTypeUtilsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ContentTypeUtils
     */
    protected $contentTypeUtils;

    public function setUp() {
        $this->contentTypeUtils = new ContentTypeUtils();
    }

    /**
     * @dataProvider getValidNormalizedContentTypeProvider
     */
    public function testNormalizeContentTypeShouldReturnType($providedContentType, $expectedType) {
        $normalizedFormat = $this->contentTypeUtils->normalize($providedContentType);
        $this->assertThat($normalizedFormat, $this->equalTo($expectedType));
    }

    /**
     * @expectedException Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException
     */
    public function testNormalizeContentTypeShouldThrowException() {
        $this->contentTypeUtils->normalize('invalidContentType');
    }


    /**
     * @dataProvider getValidAcceptContentTypeProvider
     */
    public function testGetAcceptContentTypeShouldReturnType($providedContentType, $expectedType) {
        $normalizedFormat = $this->contentTypeUtils->findAcceptType($providedContentType);
        $this->assertThat($normalizedFormat, $this->equalTo($expectedType));
    }

    public static function getValidNormalizedContentTypeProvider() {
        return array(
            array(ContentTypeUtils::SIMPLE_JSON_FORMAT, ContentTypeUtils::JSON_FORMAT),
            array(ContentTypeUtils::JSON_FORMAT, ContentTypeUtils::JSON_FORMAT),
            array(ContentTypeUtils::SIMPLE_XML_FORMAT, ContentTypeUtils::XML_FORMAT),
            array(ContentTypeUtils::XML_FORMAT, ContentTypeUtils::XML_FORMAT),

        );
    }

    public static function getValidAcceptContentTypeProvider() {
        return array(
            array("text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "application/xml"),
            array(ContentTypeUtils::SIMPLE_JSON_FORMAT, ContentTypeUtils::JSON_FORMAT),
            array(ContentTypeUtils::JSON_FORMAT, ContentTypeUtils::JSON_FORMAT),
            array(ContentTypeUtils::SIMPLE_XML_FORMAT, ContentTypeUtils::XML_FORMAT),
            array(ContentTypeUtils::XML_FORMAT, ContentTypeUtils::XML_FORMAT),

        );
    }

}
