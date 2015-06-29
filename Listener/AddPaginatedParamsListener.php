<?php

/**
 * @author Sergio Arroyo Cuevas <@delr3ves>
 */
namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AddPaginatedParamsListener extends PublicApiListener {

    public function __construct() {
    }

    /**
     * Set the query params related to pagination as attributes
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        if ($this->isApiRequest($request)) {
            $this->overrideParamIfNumeric($request, 'limit');
            $this->overrideParamIfNumeric($request, 'offset');
        }
    }

    /**
     * @param $request
     */
    private function overrideParamIfNumeric($request, $paramName) {
        if ($request->query->has($paramName)) {
            $offset = $request->query->get($paramName);
            if (is_numeric($offset)) {
                $request->attributes->set($paramName, $offset);
            }
        }
    }

}