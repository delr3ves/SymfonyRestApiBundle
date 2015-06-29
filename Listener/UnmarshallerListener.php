<?php

namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Delr3ves\RestApiBundle\HttpErrors\UnprocessableEntityError;
use Delr3ves\RestApiBundle\ApiObject\UnprocessableEntityApiObject;

use \Delr3ves\RestApiBundle\Unmarshalling\Unmarshaller;
use Delr3ves\RestApiBundle\Unmarshalling\UnableToUnmarshallException;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;
use Delr3ves\RestApiBundle\HttpErrors\UnsupportedMediaTypeError;
use Delr3ves\RestApiBundle\ApiObject\UnsupportedMediaTypeApiObject;

use Symfony\Component\HttpFoundation\Response;

class UnmarshallerListener extends PublicApiListener {

    protected $unmarshaller;

    public function __construct(Unmarshaller $unmarshaller) {
        $this->unmarshaller = $unmarshaller;
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
            $resourceClass = $request->attributes->get('resourceClassName');
            if ($resourceClass) { //have to unmarshall
                try {
                    $resource = $this->unmarshaller->unmarshall($request->getContent(),
                        $request->headers->get('content-type'), $resourceClass);
                    $request->attributes->set('resource', $resource);
                } catch (FormatNotSupportedException $e) {
                    throw $this->buildUnsupportedMediaTypeError($e);
                } catch (UnableToUnmarshallException $e) {
                    throw $this->buildUnprocessableEntityError($e);
                }
            }
        }
    }

    private function buildUnsupportedMediaTypeError($e) {
        $unsupportedMediaTypeApiObject = new UnsupportedMediaTypeApiObject();
        $unsupportedMediaTypeApiObject->setProvidedFormat($e->conflictedFormat);
        $unsupportedMediaTypeApiObject->setAvailableFormats($e->availableFormats);
        return new UnsupportedMediaTypeError($unsupportedMediaTypeApiObject);
    }

    /**
     * Creates an httpException to inform the entity is bad-formed
     * @param $e
     * @return \Delr3ves\RestApiBundle\HttpErrors\UnprocessableEntityError
     */
    private function buildUnprocessableEntityError($e) {
        $unprocessableEntityDescription = new UnprocessableEntityApiObject();
        $unprocessableEntityDescription->setFormat($e->format);
        $unprocessableEntityDescription->setPayload($e->stringResource);

        $reflectionClass = new \ReflectionClass($e->classname);
        $object = $reflectionClass->newInstanceArgs();
        $unprocessableEntityDescription->setSchema($object->getSchema());

        return new UnprocessableEntityError($unprocessableEntityDescription);
    }

}