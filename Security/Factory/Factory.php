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
namespace Duo\AtlassianCrowdAuthorizationBundle\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class SsoFactory implements SecurityFactoryInterface
{

    function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        // TODO: Implement create() method.
        $providerId = 'duo_crowd_auth_sso.security.authentication.provider.' . $id;
        $provider = new DefinitionDecorator('duo_crowd_auth_sso.security.authentication.provider');
        $provider->replaceArgument(0, new Reference($userProvider));
        $container->setDefinition($providerId, $provider);

//        $provider = $this->container->get('security.authentication.provider.eficia3_sso_saml');

        $listenerId = 'duo_crowd_auth_sso.security.authentication.listener.' . $id;
        $listener = new DefinitionDecorator('duo_crowd_auth_sso.security.authentication.listener');
        $listener->replaceArgument(2, $id);
        $listener->replaceArgument(3, $config);
        $container->setDefinition($listenerId, $listener);

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    function getPosition()
    {
        return 'form';
    }

    function getKey()
    {
        return 'duo_crowd_auth_sso';
    }

    function addConfiguration(NodeDefinition $builder)
    {
        // TODO: Implement addConfiguration() method.
    }

}
