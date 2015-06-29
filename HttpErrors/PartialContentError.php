<?php
/**
 * Exception thrown when the user looks for an embedded which can not be retrieved.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;


class PartialContentError extends BaseHttpError {

    /**
     * @param string $partialResponse will contain information about the retrieved
     * element and the reason of the failure while embedding.
     */
    public function __construct($partialResponse) {
        parent::__construct(206, $partialResponse);
    }
}
