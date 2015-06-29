<?php
/**
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\HttpErrors;


use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseHttpError extends HttpException{

    /**
     * the DTO containing the information about the error
     */
    public $errorInformation;

    public function __construct($code, $errorInformation=null) {
        $this->errorInformation = $errorInformation;
        parent::__construct($code);
    }
}
