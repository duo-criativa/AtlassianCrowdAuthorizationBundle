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

class User implements  UserInterface {

    protected $roles;
    protected $attributes;
    protected $username;
    protected $first_name;
    protected $last_name;
    protected $display_name;
    protected $email;

    /**
     * Returns the roles granted to the user.
     *
     * @return Role[] The user roles
     */
    function getRoles()
    {
        return $this->roles;
    }

    function setRoles($roles){
        $this->roles = $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * @return string The password
     */
    function getPassword()
    {
        return null;
    }

    /**
     * Returns the salt.
     *
     * @return string The salt
     */
    function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    function getUsername()
    {
        return $this->username;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * @return void
     */
    function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     * @return Boolean
     */
    function equals(UserInterface $user)
    {
        return ( $this->username == $user->getUsername() );
    }

    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }


}
