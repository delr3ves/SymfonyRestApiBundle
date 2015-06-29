<?php
/**
 * 
 *
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */

namespace Delr3ves\RestApiBundle\Tests\Unit\Unmarshalling;

use Delr3ves\RestApiBundle\Unmarshalling\UnmarshallerImpl;

class UnmarshallerImplTest extends \PHPUnit_Framework_TestCase {
    const IRRELEVANT_CLASS_NAME = 'irrelevantClassName';
    const IRRELEVANT_FORMAT = 'irrelevantFormat';
    const IRRELEVANT_PAYLOAD = 'irrelevantPayload';
    const IRRELEVANT_UNMARSHALLED_OBJECT = 'irrelevantUnmarshalledObject';
    const MARSHALLER_FACTORY_CLASS = 'Delr3ves\RestApiBundle\Unmarshalling\SpecificFormatUnmarshallerFactory';
    const SPECIFIC_FORMAT_UNMARSHALLER_CLASS = 'Delr3ves\RestApiBundle\Unmarshalling\SpecificFormatUnmarshaller';

    /**
     * @test
     */
    public function testUnmarshallShouldUseUnmarshallerFactory() {
        $unmarshaler = $this->createUnmarshaller();
        $unmarshalledObject = $unmarshaler->unmarshall(self::IRRELEVANT_PAYLOAD,
            self::IRRELEVANT_FORMAT, self::IRRELEVANT_CLASS_NAME);
        $this->assertThat($unmarshalledObject, $this->equalTo(
            self::IRRELEVANT_UNMARSHALLED_OBJECT));
    }

    /**
     * @test
     * @expectedException Delr3ves\RestApiBundle\Unmarshalling\UnableToUnmarshallException
     */
    public function testUnmarshallShouldThrowExcpetion() {
        $unmarshaler = $this->createUnmarshallerTrhowingExcpetion();
        $unmarshalledObject = $unmarshaler->unmarshall(self::IRRELEVANT_PAYLOAD,
            self::IRRELEVANT_FORMAT, self::IRRELEVANT_CLASS_NAME);
        $this->assertThat($unmarshalledObject, $this->equalTo(
            self::IRRELEVANT_UNMARSHALLED_OBJECT));
    }

    /**
     * @return UnmarshallerImpl
     */
    private function createUnmarshaller() {
        $concreteUnmarshallerMock = $this->createSpecificFormatMarshallerMock();
        $unmarshallerFactory = $this->createMarshallerFactoryMock($concreteUnmarshallerMock);

        $unmarshaller = new UnmarshallerImpl($unmarshallerFactory);
        return $unmarshaller;
    }

    /**
     * @return UnmarshallerImpl
     */
    private function createUnmarshallerTrhowingExcpetion() {
        $concreteUnmarshallerMock = $this->createSpecificFormatMarshallerThorwingExcpetionMock();
        $unmarshallerFactory = $this->createMarshallerFactoryMock($concreteUnmarshallerMock);

        $unmarshaller = new UnmarshallerImpl($unmarshallerFactory);
        return $unmarshaller;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createSpecificFormatMarshallerThorwingExcpetionMock() {
        $concreteUnmarshallerMock = $this->getMock(
            self::SPECIFIC_FORMAT_UNMARSHALLER_CLASS);
        $concreteUnmarshallerMock->expects($this->once())
            ->method('unmarshall')
            ->with(self::IRRELEVANT_PAYLOAD, self::IRRELEVANT_CLASS_NAME)
            ->will($this->throwException(new \Exception()));
        return $concreteUnmarshallerMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createSpecificFormatMarshallerMock() {
        $concreteUnmarshallerMock = $this->getMock(
            self::SPECIFIC_FORMAT_UNMARSHALLER_CLASS);
        $concreteUnmarshallerMock->expects($this->once())
            ->method('unmarshall')
            ->with(self::IRRELEVANT_PAYLOAD, self::IRRELEVANT_CLASS_NAME)
            ->will($this->returnValue(self::IRRELEVANT_UNMARSHALLED_OBJECT));
        return $concreteUnmarshallerMock;
    }

    /**
     * @param $concreteUnmarshallerMock
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createMarshallerFactoryMock($concreteUnmarshallerMock) {
        $unmarshallerFactory = $this->getMockBuilder(
            self::MARSHALLER_FACTORY_CLASS)->disableOriginalConstructor()->getMock();
        $unmarshallerFactory->expects($this->once())
            ->method('getUnmarshaller')
            ->with(self::IRRELEVANT_FORMAT)
            ->will($this->returnValue($concreteUnmarshallerMock));
        return $unmarshallerFactory;
    }

}