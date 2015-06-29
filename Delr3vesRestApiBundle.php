<?php

namespace Delr3ves\RestApiBundle;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Delr3vesRestApiBundle extends Bundle {


    function __construct() {
        AnnotationRegistry::registerLoader('class_exists');
    }
}
