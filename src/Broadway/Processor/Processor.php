<?php

/*
 * This file is part of the broadway/broadway package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Broadway\Processor;

use Broadway\Domain\DomainMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Base class for event stream processors.
 */
#[AsMessageHandler]
abstract class Processor
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(DomainMessage $domainMessage): void
    {
        $event = $domainMessage->getPayload();
        $method = $this->getHandleMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event, $domainMessage);
    }

    /**
     * @param mixed $event
     */
    private function getHandleMethod($event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'handle'.end($classParts);
    }
}
