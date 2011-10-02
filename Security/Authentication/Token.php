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

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class Token extends AbstractToken
{
    protected $crowd_token;

    protected $username;
    protected $password;


    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    function getCredentials()
    {
        // TODO: Implement getCredentials() method.
        return '';
    }

    public function setCrowdToken($crowd_token)
    {
        $this->crowd_token = $crowd_token;
    }

    public function getCrowdToken()
    {
        return $this->crowd_token;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }


}
