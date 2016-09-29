<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */
namespace GpsLab\Domain\Event\Listener\Locator;

use GpsLab\Domain\Event\EventInterface;
use GpsLab\Domain\Event\Listener\ListenerCollection;
use GpsLab\Domain\Event\Listener\ListenerInterface;
use GpsLab\Domain\Event\Listener\VoterListenerInterface;

class VoterLocator implements LocatorInterface
{
    /**
     * @var VoterListenerInterface[]
     */
    private $listeners = [];

    /**
     * @param EventInterface $event
     *
     * @return ListenerInterface[]
     */
    public function getListenersForEvent(EventInterface $event)
    {
        $listeners = new ListenerCollection();

        foreach ($this->listeners as $listener) {
            if ($listener->isSupportedEvent($event)) {
                $listeners->add($listener);
            }
        }

        return $listeners;
    }

    /**
     * @param VoterListenerInterface $listener
     */
    public function register(VoterListenerInterface $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * @return ListenerCollection
     */
    public function getRegisteredEventListeners()
    {
        return new ListenerCollection($this->listeners);
    }
}