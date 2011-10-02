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

    protected $saml_service_provider;
    protected $userProvider;
    protected $em;

    function __construct($userProvider, LoggerInterface $logger = null )
    {
        $this->userProvider = $userProvider;
        $this->logger = $logger;
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

        // Inicia o cURL
        $ch = curl_init();

        $sso = new CrowdSSO(null,$this->logger);
        if($token->getCrowdToken()!=''){


            $content = $sso->retrieveToken($token->getCrowdToken());
            $content2 = $sso->getUserAttributes("paulo");

            if (null !== $this->logger)
            {
                $this->logger->info(__METHOD__ . ' | Retorno do Crowd: ' . $content);
                $this->logger->info(__METHOD__ . ' | Retorno do Crowd USER ATTRS: ' . $content2);
            }

        } else {
            $content = $sso->login($token->getUsername(), $token->getPassword());
            if (null !== $this->logger)
            {
                $this->logger->info(__METHOD__ . ' | Retorno do Crowd: ' . $content);
            }
        }


        // Encerra o cURL
        curl_close ($ch);

        return $token;
        /*$as->requireAuth();

        if ($as->isAuthenticated())
        {

            $attributes = $as->getAttributes();
            $authdata = $as->getAuthDataArray();

            $token = new SsoSamlToken($attributes['groups']);
            $username = $attributes['username'][0];
            $id = $attributes['id'][0];
            $email = $attributes['email'][0];
            try
            {
                $user = $this->userProvider->loadUserByUsername($username);
            } catch (\Symfony\Component\Security\Core\Exception\UsernameNotFoundException $e)
            {
                $user = new \Eficia3\SsoSamlAuthBundle\Entity\User();
                $user->setId($id);
            }

            $user->setUsername($username);
            $user->setUsernameCanonical($username);
            $user->setEmail($email);
            $user->setEmailCanonical($email);
//                $user->setGroups($attributes['groups']);
//                $user->setEnabled($attributes['email']);

            $user->setAuthenticationData($authdata);
            $user->setLastLogin(new \DateTime);
            $this->userProvider->updateUser($user);

            $token->setUser($user);
            $token->setAuthenticated(true);


            return $token;
        }*/

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
        return ($token instanceof SsoToken);
    }

}
