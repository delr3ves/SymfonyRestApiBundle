<?php
/**
 * In charge to un-marshall a string formatted object into a dto object.
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

class UnmarshallerImpl implements  Unmarshaller {

    /**
     * @var SpecificFormatUnmarshallerFactory
     */
    protected $specificFormatUnmarshallerFactory;

    public function __construct(SpecificFormatUnmarshallerFactory $specificFormatUnmarshallerFactory) {
        $this->specificFormatUnmarshallerFactory = $specificFormatUnmarshallerFactory;
    }


    /**
     * @see Unmarshaller::unmarshall
     */
    public function unmarshall($payload, $format, $classname) {
            $specificFormatUnmarshaller =
                    $this->specificFormatUnmarshallerFactory->getUnmarshaller($format);
        try {
            return $specificFormatUnmarshaller->unmarshall($payload, $classname);
        } catch (\Exception $e) {
            throw new UnableToUnmarshallException($payload, $classname, $format);
        }
    }

}
