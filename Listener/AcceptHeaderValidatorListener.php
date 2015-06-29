<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use \Delr3ves\RestApiBundle\Unmarshalling\Unmarshaller;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;
use Delr3ves\RestApiBundle\ApiObject\NotAcceptableApiObject;
use Delr3ves\RestApiBundle\Unmarshalling\ContentTypeUtils;
use Delr3ves\RestApiBundle\HttpErrors\NotAcceptableError;
use Symfony\Component\HttpFoundation\Response;

class AcceptHeaderValidatorListener extends PublicApiListener {

    protected $contentTypeUtils;

    public function __construct(ContentTypeUtils $contentTypeUtils) {
        $this->contentTypeUtils = $contentTypeUtils;
    }

    /**
     * Set the query params as http headers and change the method verb if
     * received by heather.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        if ($this->isApiRequest($request)) {
            $resourceClass = $request->attributes->get('responseClassName');
            if ($resourceClass) { //have to unmarshall
                try {
                    $this->contentTypeUtils->findAcceptType($request->headers->get('accept'));
                } catch (FormatNotSupportedException $e) {
                    throw $this->buildUnsupportedMediaTypeError($e);
                }
            }
        }
    }

    private function buildUnsupportedMediaTypeError($e) {
        $notAcceptableApiObject = new NotAcceptableApiObject();
        $notAcceptableApiObject->setProvidedFormat($e->conflictedFormat);
        $notAcceptableApiObject->setAvailableFormats($e->availableFormats);
        return new NotAcceptableError($notAcceptableApiObject);
    }


}
