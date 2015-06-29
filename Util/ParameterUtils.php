<?php
/**
 * Provides some util methods to work with the received parameters in the request.
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Util;

use Symfony\Component\HttpFoundation\Request;

class ParameterUtils {

    const EMBEDDED_PARAMETER = 'embedded';

    public function getEmbedded(Request $request) {
        $embeddedList = array();
        $embedded = $request->get(self::EMBEDDED_PARAMETER);
        if ($embedded) {
            $embeddedList = $this->processList($embedded);
        }
        return $embeddedList;
    }


    public function processList($parameter) {
        $parameterList = explode(',', $parameter);
        $query = array();
        foreach ($parameterList as $item) {
            $query[] = $this->toCamelCase($item);
        }
        return $query;
    }

    /**
     * Convertes a string from '-' based to camelCase.
     * @param $text
     * @return string
     */
    public function toCamelCase($text) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $text))));
    }
}
