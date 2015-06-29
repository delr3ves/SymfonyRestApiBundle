<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Delr3ves\RestApiBundle\Unmarshalling\ContentTypeUtils;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;
use Symfony\Component\HttpFoundation\Request;
use Delr3ves\RestApiBundle\Marshalling\Marshaller;



class ExceptionSerializerListener extends PublicApiListener {

    /**
     * @var ContentTypeUtils
     */
    private $contentTypeUtils;
    /**
     * @var MarshallerImpl
     */
    private $marshaller;

    public function __construct(ContentTypeUtils $contentTypeUtils,
           Marshaller $marshaller) {
        $this->contentTypeUtils = $contentTypeUtils;
        $this->marshaller = $marshaller;
    }

    /**
     * Set the query params as http headers and change the method verb if
     * received by heather.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $request = $event->getRequest();
        if ($this->isApiRequest($request)) {
            $exception = $event->getException();
            if (is_a($exception, 'Delr3ves\RestApiBundle\HttpErrors\BaseHttpError')) {
                $contentType = $this->getContentType($request);
                $errorInformation = $this->marshaller->marshall(
                    $exception->errorInformation, $contentType);
                $response = new Response($errorInformation);
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->add(array('content-type'=> $contentType));
                $event->setResponse($response);
            }
        }
    }

    private function getContentType(Request $request) {
        try {
            $format = $this->contentTypeUtils->findAcceptType(
                    $request->headers->get('accept'));
        } catch (FormatNotSupportedException $e){
            $format = 'application/json';
        }
        return $format;
    }
}
