<?php
/**
 * Exception thrown when the user try to access to a private entry point but is
 * not logged into the system.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\UnauthorizedApiObject;

class UnauthorizedError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the way to
     * authenticate.
     */
    public function __construct(UnauthorizedApiObject $errorInformation) {
        parent::__construct(401, $errorInformation);
    }
}
