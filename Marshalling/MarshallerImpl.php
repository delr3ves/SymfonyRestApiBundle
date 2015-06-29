<?php
/**
 * Converts DTO objects into string representation according to the given format.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Marshalling;

class MarshallerImpl implements Marshaller {

    protected $marshallerFactory;

    public function __construct(SpecificFormatMarshallerFactory $marshallerFactory) {
        $this->marshallerFactory = $marshallerFactory;
    }

    /**
     *
     * @param $object
     * @param array $embedded
     * @param int $level
     */
    public function marshall($object, $format, array $embedded = array()) {
        $marshaller = $this->marshallerFactory->getMarshaller($format);
        return $marshaller->marshall($object, $embedded);
    }


}
