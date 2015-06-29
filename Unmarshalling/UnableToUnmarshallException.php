<?php
/**
 * Exception thrown when the provided string representation is not in the proper
 * format so can not unmarshall to an object.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

class UnableToUnmarshallException extends \DomainException {

    /**
     * @var string
     */
    public $stringResource;
    /**
     * @var string
     */
    public $classname;

    /**
     * @var string
     */
    public $format;

    public function __construct($stringResource, $classname, $format,
                                $message ='', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->stringResource = $stringResource;
        $this->classname = $classname;
        $this->format = $format;
    }



}
