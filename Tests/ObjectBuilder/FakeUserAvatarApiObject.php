<?php
/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */


namespace Delr3ves\RestApiBundle\Tests\ObjectBuilder;

use Delr3ves\RestApiBundle\Annotations\XmlContainerTag;
use Delr3ves\RestApiBundle\Annotations\Embedded;
use Delr3ves\RestApiBundle\Annotations\TypeHint;
use Delr3ves\RestApiBundle\Annotations\Collection;

use Delr3ves\RestApiBundle\ApiObject\BaseApiObject;

/**
 * @XmlContainerTag(tagname="avatar")
 */
class FakeUserAvatarApiObject extends BaseApiObject {


}
