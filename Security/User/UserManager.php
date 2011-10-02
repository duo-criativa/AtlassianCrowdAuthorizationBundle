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
 
class UserManager implements UserProviderInterface {
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
        // TODO: Implement loadUserByUsername() method.
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
        // TODO: Implement refreshUser() method.
        return $user;
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


}
