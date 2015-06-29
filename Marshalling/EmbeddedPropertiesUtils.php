<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ju
 * Date: 22/06/12
 * Time: 16:17
 * To change this template use File | Settings | File Templates.
 */

namespace Delr3ves\RestApiBundle\Marshalling;

use Delr3ves\RestApiBundle\Annotations\ApiAnnotationReader;

class EmbeddedPropertiesUtils {

    /**
     * @var ApiAnnotationReader
     */
    private $apiAnnotationReader;

    public function __construct(ApiAnnotationReader $apiAnnotationReader) {
        $this->apiAnnotationReader = $apiAnnotationReader;
    }

    public function haveToEmbedded(\ReflectionProperty $property, $embedded, $deep) {
        $isEmbedded = $this->apiAnnotationReader->isEmbedded($property);
        $embeddedAll = in_array('*', $embedded);
        return (!$isEmbedded
            || ($deep==1 && ($isEmbedded && in_array($property->getName(), $embedded)))
            || $embeddedAll);
    }


}
