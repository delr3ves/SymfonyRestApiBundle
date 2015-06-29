<?php
/**
 * Exception thrown when the provided Accept header is bad formed.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\NotAcceptableApiObject;

class NotAcceptableError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the provided
     * accept header and the supported ones.
     */
    public function __construct(NotAcceptableApiObject $errorInformation) {
        parent::__construct(406, $errorInformation);
    }
}
