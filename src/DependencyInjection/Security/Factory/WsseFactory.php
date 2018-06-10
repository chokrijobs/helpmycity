<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 06/06/18
 * Time: 00:39
 */

namespace App\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use AppBundle\Security\Authentication\Provider\WsseProvider;
use AppBundle\Security\Firewall\WsseListener;

class WsseFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.wsse.' . $id;
        $container
            ->setDefinition($providerId, new ChildDefinition(WsseProvider::class))
            ->setArgument(0, new Reference($userProvider));

        $listenerId = 'security.authentication.listener.wsse.' . $id;
        $container->setDefinition($listenerId, new ChildDefinition(WsseListener::class));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'wsse';
    }

    public function addConfiguration(NodeDefinition $node)
    {
    }
}