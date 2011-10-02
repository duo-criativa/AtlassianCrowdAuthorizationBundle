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
    protected $nameID;

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
        return $this->attributes['username'];
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
        $thisnameID = $this->getNameID();
        $nameID = $user->getNameID();
        return ( $thisnameID['Value'] == $nameID['Value'] && $thisnameID['SPNameQualifier'] == $nameID['SPNameQualifier'] && $thisnameID['Format'] == $nameID['Format'] );
    }

    function getAttributes($attributes){
        return $this->attributes;
    }

    function setAttributes($attributes){
        $this->attributes = $attributes;
    }

    public function setNameID($nameID)
    {
        $this->nameID = $nameID;
    }

    public function getNameID()
    {
        return $this->nameID;
    }


}
