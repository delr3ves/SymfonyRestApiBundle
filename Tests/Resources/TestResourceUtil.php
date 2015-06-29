<?php
/**
 *

 * @author Sergio Arroyo <@delr3ves>
 * @since 1.0
 */

namespace Delr3ves\RestApiBundle\Tests\Resources;

class TestResourceUtil {

    public static function getBaseResourceAbsolutePath($resourcePath) {
        return getcwd(). '/Tests/Resources/' . $resourcePath;
    }

    public static function readResource($resourcePath) {
        return file_get_contents(self::getBaseResourceAbsolutePath($resourcePath));
    }
}
