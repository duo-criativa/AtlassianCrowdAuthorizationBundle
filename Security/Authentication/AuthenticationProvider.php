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

namespace Duo\AtlassianCrowdAuthorizationBundle\Security\Authentication;


use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use \Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class AuthenticationProvider implements AuthenticationProviderInterface
{

    protected $serviceProvider;
    protected $userProvider;
    protected $em;

    function __construct($userProvider, $serviceProvider, $container, LoggerInterface $logger = null)
    {
        $this->userProvider = $userProvider;
        $this->logger = $logger;
        $this->container = $container;
        $serviceProvider = new $serviceProvider();
        $serviceProvider->setServer($container->getParameter('crowd.server'));
        $serviceProvider->setAppName($container->getParameter('crowd.app_name'));
        $serviceProvider->setAppPassword($container->getParameter('crowd.app_password'));
        $this->serviceProvider = $serviceProvider;
    }

    /**
     * Attempts to authenticates a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    function authenticate(TokenInterface $token)
    {

        try
        {
            if ($token->getCrowdToken() != '')
            {
                $service_response = $this->serviceProvider->retrieveToken($token->getCrowdToken());
            } else
            {
                $service_response = $this->serviceProvider->createSessionToken($token->getUsername(), $token->getPassword());
            }
            if (null !== $this->logger)
            {
                $this->logger->info(__METHOD__ . ' | Retorno do AuthenticatorProvider: ' . print_r($service_response, true));
            }

            if (!$service_response['user']['active']) throw new Symfony\Component\Security\Core\Exception\AuthenticationException('User is not active.');

            $user = new DuoAtlassianCrowdAuthorizationBundle\Security\User();
            $user->setUsername($service_response['user']['username']);
            $user->setEmail($service_response['user']['email']);
            $user->setFirstName($service_response['user']['first_name']);
            $user->setLastName($service_response['user']['last_name']);
            $user->setDisplayName($service_response['user']['display_name']);
            $user->setActive($service_response['user']['active']);

            $groups = $this->serviceProvider->retrieveUserGroups($user->getUsername());
            $user->setRoles($groups);

            $token->setUser($user);
            $token->setAuthenticated(true);

        } catch (\Duo\AtlassianCrowdAuthorization\Exception\InvalidUserAuthenticationException $e)
        {
            throw new Symfony\Component\Security\Core\Exception\AuthenticationException($e->getMessage());
        }

        return $token;

    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return Boolean true if the implementation supports the Token, false otherwise
     */
    function supports(TokenInterface $token)
    {
        // TODO: Implement supports() method.
        return ($token instanceof Token);
    }

}
