<?php
/**
 *
 *
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */
namespace Delr3ves\RestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Delr3ves\RestApiBundle\Docs\ApiObjectPopulator;

class ExampleObjectController extends Controller {

    private $populator;

    public function __construct(ApiObjectPopulator $populator) {
        $this->populator = $populator;
    }

    public function populate(Request $request) {
        $class = $request->query->get('class');
        return $this->populator->populate($class);
    }

}
