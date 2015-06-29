<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpFoundation\Request;

class PublicApiListener {

    private $urlPrefixes = array();

    public function isApiRequest(Request $request) {
        $uri = $request->getUri();
        foreach ($this->urlPrefixes as $prefix) {
            if (strstr($uri, $prefix)) {
                return true;
            }
        }
        return false;
    }

    public function setUrlPrefixes($urlPrefixes) {
        $this->urlPrefixes = $urlPrefixes;
    }
}
