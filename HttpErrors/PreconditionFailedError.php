<?php
/**
 * Exception thrown when the a Exception happens.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\ViolationsApiObject;

class PreconditionFailedError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the way to
     * authenticate.
     */
    public function __construct(ViolationsApiObject $errorInformation) {
        parent::__construct(412, $errorInformation);
    }
}
