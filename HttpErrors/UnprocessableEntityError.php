<?php
/**
 * Exception thrown when the provided payload is bad formed.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\UnprocessableEntityApiObject;

class UnprocessableEntityError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the provided
     * payload the expected format and the schema
     */
    public function __construct(UnprocessableEntityApiObject $errorInformation) {
        parent::__construct(422, $errorInformation);
    }
}
