<?php
 /**
 * ${description}
 *
 * Propriedade intelectual de Duo Criativa (www.duocriativa.com.br).
 *
 * @author     Paulo R. Ribeiro <paulo@duocriativa.com.br>
 * @package    ${package}
 * @subpackage ${subpackage}
 */

namespace Duo\AtlassianCrowdAuthorizationBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use \Duo\AtlassianCrowdAuthorizationBundle\Security\Authentication\Token;

class AuthenticationListener implements ListenerInterface
{

    protected $em;
    /**
     * Constructor.
     *
     * @param SecurityContextInterface               $securityContext       A SecurityContext instance
     * @param AuthenticationManagerInterface         $authenticationManager An AuthenticationManagerInterface instance
     * @param EntityManager                          $em
     * @param string                                 $providerKey
     * @param array                                  $options               An array of options for the processing of a
     *                                                                      successful, or failed authentication attempt
     * @param LoggerInterface                        $logger                A LoggerInterface instance
     * @param EventDispatcherInterface               $dispatcher            An EventDispatcherInterface instance
     */
    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, $providerKey, array $options = array(), LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null, $container)
    {
        if (empty($providerKey))
        {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->providerKey = $providerKey;

        $this->options = $options;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
//        $this->em = $em;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    function handle(GetResponseEvent $event)
    {
        if (null !== $this->logger)
        {
            $this->logger->info(__METHOD__ . ' | Tentando autenticar o usuario');
        }

        $token = new Token();

        $cookies = $event->getRequest()->cookies;
        if ($cookies->has('crowd_token_key')) {
            $token->setCrowdToken($cookies->get('crowd_token_key'));
        } else {
            $post_params = $event->getRequest()->request->all();
            if(isset($post_params['crowd_auth_login'])){
                $login_data = $post_params['crowd_auth_login'];
                $token->setUsername($login_data['_username']);
                $token->setPassword($login_data['_password']);
            } else {
                $parameters = array();
                $parameters['last_username'] = '';
                return $event->setResponse($this->container->get('templating')->renderResponse('DuoAtlassianCrowdAuthorizationBundle:Default:login.html.twig', $parameters));
            }
        }


        try
        {
            $returnValue = $this->authenticationManager->authenticate($token);

            if ($returnValue instanceof TokenInterface)
            {

                if (null !== $this->logger)
                {
                    $this->logger->info(sprintf('Authentication returned the following attributes from Crowd: %s', print_r($returnValue->getAttributes(), true)));
                }

                return $this->securityContext->setToken($returnValue);
            } else if ($returnValue instanceof Response)
            {
                return $event->setResponse($returnValue);
            }
        } catch (AuthenticationException $e)
        {
            // you might log something here
        }

        $response = new Response();
        $response->setStatusCode(403);
        $event->setResponse($response);

    }


}
