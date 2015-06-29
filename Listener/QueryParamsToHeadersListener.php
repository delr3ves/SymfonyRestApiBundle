<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class QueryParamsToHeadersListener extends PublicApiListener {

    /**
     * Set the query params as http headers and change the method verb if
     * received by heather.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        if ($this->isApiRequest($request)) {

            $queryParams = $request->query->all();
            foreach ($queryParams as $queryKey => $queryValue) {
                $request->headers->add(array(strtolower($queryKey) => $queryValue));
            }

            if ($request->headers->get('http-method-override', false)
                        && strtolower($request->getMethod()) != 'get') {
                $request->setMethod($request->headers->get('http-method-override'));
            }
        }
    }

}
