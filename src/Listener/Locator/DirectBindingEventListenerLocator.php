<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Domain\Event\Listener\Locator;

use GpsLab\Domain\Event\Event;
use GpsLab\Domain\Event\Listener\ListenerCollection;
use GpsLab\Domain\Event\Listener\ListenerInterface;
use GpsLab\Domain\Event\NameResolver\EventNameResolverInterface;

class DirectBindingEventListenerLocator implements EventListenerLocator
{
    /**
     * @var ListenerCollection[]
     */
    private $listeners = [];

    /**
     * @var EventNameResolverInterface
     */
    private $resolver;

    /**
     * @param EventNameResolverInterface $resolver
     */
    public function __construct(EventNameResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param Event $event
     *
     * @return ListenerInterface[]|ListenerCollection
     */
    public function listenersOfEvent(Event $event)
    {
        $event_name = $this->resolver->getEventName($event);

        if (isset($this->listeners[$event_name])) {
            return $this->listeners[$event_name];
        } else {
            return new ListenerCollection();
        }
    }

    /**
     * @param string            $event_name
     * @param ListenerInterface $listener
     */
    public function register($event_name, ListenerInterface $listener)
    {
        if (!isset($this->listeners[$event_name])) {
            $this->listeners[$event_name] = new ListenerCollection();
        }

        $this->listeners[$event_name]->add($listener);
    }
}