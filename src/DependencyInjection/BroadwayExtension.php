<?php

declare(strict_types=1);

/*
 * This file is part of the broadway/broadway-bundle package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Broadway\Bundle\BroadwayBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class BroadwayExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (isset($mergedConfig['event_store'])) {
            $container->setParameter('broadway.event_store.service_id', $mergedConfig['event_store']);
        }

        if (isset($mergedConfig['read_model'])) {
            $container->setParameter('broadway.read_model_repository_factory.service_id', $mergedConfig['read_model']);
        }

        $this->loadSerializers($mergedConfig['serializer'], $container, $loader);

    }

    private function loadSerializers(array $config, ContainerBuilder $container, XmlFileLoader $loader): void
    {
        $loader->load('serializers.xml');

        foreach ($config as $serializer => $serviceId) {
            $container->setParameter(sprintf('broadway.serializer.%s.service_id', $serializer), $serviceId);
        }
    }
}
