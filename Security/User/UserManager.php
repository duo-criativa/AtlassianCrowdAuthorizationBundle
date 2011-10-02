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

namespace Duo\AtlassianCrowdAuthorizationBundle\Security\User;

use \Symfony\Component\Security\Core\User\UserInterface;
use \Symfony\Component\Security\Core\User\UserProviderInterface;

class UserManager implements UserProviderInterface
{

    protected $serviceProvider;

    function __construct($serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @throws UsernameNotFoundException if the user is not found
     * @param string $username The username
     *
     * @return UserInterface
     */
    function loadUserByUsername($username)
    {
        $service_response = $this->serviceProvider->retrieveUser($username);
        return $this->createUserObject($service_response);
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation if it decides to reload the user data
     * from the database, or if it simply merges the passed User into the
     * identity map of an entity manager.
     *
     * @throws UnsupportedUserException if the account is not supported
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    function refreshUser(UserInterface $user)
    {
        $service_response = $this->serviceProvider->retrieveUser($user->getUsername());
        return $this->createUserObject($service_response);
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }

    protected function createUserObject($service_response)
    {
        $user = new DuoAtlassianCrowdAuthorizationBundle\Security\User();
        $user->setUsername($service_response['username']);
        $user->setEmail($service_response['email']);
        $user->setFirstName($service_response['first_name']);
        $user->setLastName($service_response['last_name']);
        $user->setDisplayName($service_response['display_name']);
        $user->setActive($service_response['active']);

        $groups = $this->serviceProvider->retrieveUserGroups($user->getUsername());
        $user->setRoles($groups);

        return $user;
    }

}
