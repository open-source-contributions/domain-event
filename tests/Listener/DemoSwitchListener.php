<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Domain\Event\Tests\Listener;

use GpsLab\Domain\Event\EventInterface;
use GpsLab\Domain\Event\Listener\AbstractSwitchListener;
use GpsLab\Domain\Event\Tests\Event\PurchaseOrderCreatedEvent;

class DemoSwitchListener extends AbstractSwitchListener
{
    /**
     * @var EventInterface
     */
    private $last_event;

    /**
     * @param PurchaseOrderCreatedEvent $event
     */
    protected function handlePurchaseOrderCreated(PurchaseOrderCreatedEvent $event)
    {
        $this->last_event = $event;
    }

    /**
     * @return EventInterface
     */
    public function getLastEvent()
    {
        return $this->last_event;
    }
}
