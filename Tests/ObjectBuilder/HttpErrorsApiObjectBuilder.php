<?php
/**
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\ObjectBuilder;

use Delr3ves\RestApiBundle\ApiObject\NotAcceptableApiObject;

class HttpErrorsApiObjectBuilder {

    public function getNotAcceptableError($format='invalidFormat') {
        $notAcceptableTypeApiObject = new NotAcceptableApiObject();
        $notAcceptableTypeApiObject->setProvidedFormat($format);
        $notAcceptableTypeApiObject->setAvailableFormats(
            array('format' => 'normalizedFormat'));
        return new NotAcceptableError($notAcceptableTypeApiObject);
    }
}
