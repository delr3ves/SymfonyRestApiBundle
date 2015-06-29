<?php
/**
 * Exception thrown when the provided Content-Type is not supported.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\UnsupportedMediaTypeApiObject;

class UnsupportedMediaTypeError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the provided
     * format and the expected ones
     */
    public function __construct(UnsupportedMediaTypeApiObject $errorInformation) {
        parent::__construct(415, $errorInformation);
    }
}
