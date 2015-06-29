<?php
/**
 * Exception thrown when the user try to access to a private entry and the user
 * has no permission enough to perform the action.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\ForbiddenApiObject;

class ForbiddenError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the way to
     * authenticate.
     */
    public function __construct(ForbiddenApiObject $errorInformation) {
        parent::__construct(403, $errorInformation);
    }
}
