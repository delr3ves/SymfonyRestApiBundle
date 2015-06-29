<?php
/**
 * Exception thrown when the provided format is not available in the system.
 * It will contain information about the given format and also the available
 * formats in the system.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Unmarshalling;

class FormatNotSupportedException extends \DomainException {

    /**
     * @var string
     */
    public $conflictedFormat;
    /**
     * @var array
     */
    public $availableFormats;


    public function __construct($conflictedFormat, $availableFormats,
                                $code = 0, \Exception $previous = null) {
        $message = sprintf('Format "%s" not supported, try with [%s]',
             $conflictedFormat, implode(', ', array_keys($availableFormats)));
        parent::__construct($message, $code, $previous);

        $this->conflictedFormat = $conflictedFormat;
        $this->availableFormats = $availableFormats;
    }

}
