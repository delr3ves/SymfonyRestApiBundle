<?php
/**
 * Defines the annotation which contains the container tag name for every class.
 * It will defined as
 *
 *
 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Annotations;



/**
 * @Annotation
 */
class XmlContainerTag {
    public $tagname;

    public function __construct($tagname) {
        $this->tagname = $tagname;
    }
}

