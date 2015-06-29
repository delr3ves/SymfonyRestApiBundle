<?php
/**
 * In charge to verify if the current user can perfomr the acction. It will check
 * it according to defaults.role propertie defined in routing.yml file.
 *
 * @author Sergio Arroyo <@delr3ves>
 */
namespace Delr3ves\RestApiBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Delr3ves\RestApiBundle\HttpErrors\UnprocessableEntityError;
use Delr3ves\RestApiBundle\ApiObject\UnprocessableEntityApiObject;

use \Delr3ves\RestApiBundle\Unmarshalling\Unmarshaller;
use Delr3ves\RestApiBundle\Unmarshalling\UnableToUnmarshallException;
use Delr3ves\RestApiBundle\Unmarshalling\FormatNotSupportedException;
use Delr3ves\RestApiBundle\HttpErrors\UnsupportedMediaTypeError;
use Delr3ves\RestApiBundle\ApiObject\UnsupportedMediaTypeApiObject;

use Symfony\Component\HttpFoundation\Response;

class GrantListener extends PublicApiListener {

    protected $securityContext;

    public function __construct(SecurityContext $securityContext) {
        $this->securityContext = $securityContext;
    }

    /**
     * Set the query params as http headers and change the method verb if
     * received by heather.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        if ($this->isApiRequest($event->getRequest())) {
            $attributes = $event->getRequest()->attributes;
            if ($attributes->has('role')) {
                $role = $attributes->get('role');
                if (false === $this->securityContext->isGranted($role)) {
                    throw $this->buildException($this->securityContext->getToken());
                }
            }
        }
    }
    private function buildException(TokenInterface $token) {
        if ($token instanceof AnonymousToken) {
            return new AuthenticationException(
                'you are not logged into the system');
        } else {
            return new AccessDeniedException();
        }
    }
}
