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

namespace Broadway\CommandHandling\Testing;

use Broadway\CommandHandling\CommandHandler;
//use Broadway\EventHandling\EventBus;
//use Broadway\EventHandling\SimpleEventBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\MessageBus;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\InMemoryEventStore;
use Broadway\EventStore\TraceableEventStore;
use PHPUnit\Framework\TestCase;

/**
 * Base test case that can be used to set up a command handler scenario.
 */
abstract class CommandHandlerScenarioTestCase extends TestCase
{
    /**
     * @var Scenario
     */
    protected $scenario;
    
    protected $eventBus;

    protected function setUp(): void
    {
        $this->scenario = $this->createScenario();
    }

    protected function createScenario(): Scenario
    {
        $eventStore = new TraceableEventStore(new InMemoryEventStore());
        $eventBus = new MessageBus();
        $commandHandler = $this->createCommandHandler($eventStore, $eventBus);

        return new Scenario($this, $eventStore, $commandHandler);
    }

    /**
     * Create a command handler for the given scenario test case.
     */
    abstract protected function createCommandHandler(EventStore $eventStore, MessageBusInterface $eventBus): CommandHandler;
}
