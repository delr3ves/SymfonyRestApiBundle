<?php
/**
 * Defines the annotation which contains the class of the element in order to
 * provide some information for unmarshaller.
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */

class TypeHint {
    public $hint;

    public function __construct($hint) {
        $this->hint = $hint;
    }
}

