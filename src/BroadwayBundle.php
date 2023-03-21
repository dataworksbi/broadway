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

namespace Broadway\Bundle\BroadwayBundle;

use Broadway\Bundle\BroadwayBundle\DependencyInjection\RegisterEventStoreCompilerPass;
use Broadway\Bundle\BroadwayBundle\DependencyInjection\RegisterMetadataEnricherSubscriberPass;
use Broadway\Bundle\BroadwayBundle\DependencyInjection\RegisterReadModelRepositoryFactoryCompilerPass;
use Broadway\Bundle\BroadwayBundle\DependencyInjection\RegisterSerializersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BroadwayBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterEventStoreCompilerPass());
        $container->addCompilerPass(new RegisterReadModelRepositoryFactoryCompilerPass());

        $container->addCompilerPass(
            new RegisterMetadataEnricherSubscriberPass(
                'broadway.metadata_enriching_event_stream_decorator',
                'broadway.metadata_enricher'
            )
        );
        $container->addCompilerPass(
            new RegisterSerializersCompilerPass()
        );
    }
}
