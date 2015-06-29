<?php
/**
 * Exception thrown when the provided Accept header is bad formed.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;

use Delr3ves\RestApiBundle\ApiObject\NotFoundApiObject;

class NotFoundError extends BaseHttpError {

    /**
     * @param string $errorInformation will contain information about the element
     * found and the search criteria.
     */
    public function __construct(NotFoundApiObject $errorInformation) {
        parent::__construct(404, $errorInformation);
    }
}
