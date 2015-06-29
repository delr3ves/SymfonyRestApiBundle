<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

use Delr3ves\RestApiBundle\Unmarshalling\ContentTypeUtils;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;
use Symfony\Component\HttpFoundation\Request;
use Delr3ves\RestApiBundle\Marshalling\Marshaller;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Delr3ves\RestApiBundle\Patches\InternalResponse;
use Delr3ves\RestApiBundle\Util\ParameterUtils;

class MarshallerListener extends PublicApiListener {

    /**
     * @var ContentTypeUtils
     */
    private $contentTypeUtils;
    /**
     * @var Marshaller
     */
    private $marshaller;

    /**
     * @var ParametersUtils;
     */
    private $parameterUtils;


    public function __construct(ContentTypeUtils $contentTypeUtils,
                                Marshaller $marshaller,
                                ParameterUtils $parameterUtils) {
        $this->contentTypeUtils = $contentTypeUtils;
        $this->marshaller = $marshaller;
        $this->parameterUtils = $parameterUtils;
    }

    /**
     * Set the query params as http headers and change the method verb if
     * received by heather.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event) {
        $request = $event->getRequest();
        if ($this->isApiRequest($request)) {
            $result = $event->getControllerResult();
            $format = $this->contentTypeUtils->findAcceptType($request->headers->get('accept'));
            $contentType = $this->contentTypeUtils->findAcceptType($format);

            $response = new Response();
            if ($result || is_array($result)) {
                if ($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
                    $embedded = $this->parameterUtils->getEmbedded($request);
                    $body = $this->marshaller->marshall($result, $contentType, $embedded);
                    $response->setStatusCode($this->getStatusCodeByVerb($request->getMethod()));
                    $response->setContent($body);
                    $response->headers->add(array('content-type' => $contentType));
                } else {
                    $response = new InternalResponse();
                    $response->setContent($result);
                }
            }
            else {
                $response->setStatusCode($this->getStatusCodeByVerb($request->getMethod()));
            }

            $event->setResponse($response);
        }
    }

    public function getStatusCodeByVerb($method) {
        switch ($method) {
            case 'GET':
                return 200;
            case 'POST':
                return 201;
            case 'DELETE':
                return 204;
            default:
                return 200;
        }

    }

}
