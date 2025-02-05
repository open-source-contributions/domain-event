<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Domain\Event\Tests\Aggregator;

use GpsLab\Domain\Event\Event;
use GpsLab\Domain\Event\Tests\Fixture\DemoAggregatorRaiseInSelf;
use GpsLab\Domain\Event\Tests\Fixture\PurchaseOrderCreatedEvent;

class AggregateEventsRaiseInSelfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DemoAggregatorRaiseInSelf
     */
    private $aggregator;

    protected function setUp()
    {
        $this->aggregator = new DemoAggregatorRaiseInSelf();
    }

    public function testRaiseAndPullEvents()
    {
        $this->assertEquals([], $this->aggregator->pullEvents());

        $events = [
            $this->getMock(Event::class),
            $this->getMock(Event::class),
        ];

        foreach ($events as $event) {
            $this->aggregator->raiseEvent($event);
            $this->assertNull($this->aggregator->getRaiseInSelfEvent());
        }

        $this->assertEquals($events, $this->aggregator->pullEvents());
        $this->assertEquals([], $this->aggregator->pullEvents());
    }

    public function testRaiseInSel()
    {
        $this->assertEquals([], $this->aggregator->pullEvents());

        $event1 = new PurchaseOrderCreatedEvent();
        $event2 = new \Acme_Demo_PurchaseOrderCreated();

        $this->aggregator->raiseEvent($event1);
        $this->assertEquals($event1, $this->aggregator->getRaiseInSelfEvent());

        $this->aggregator->raiseEvent($event2);
        $this->assertEquals($event2, $this->aggregator->getRaiseInSelfEvent());

        $this->assertEquals([$event1, $event2], $this->aggregator->pullEvents());
        $this->assertEquals([], $this->aggregator->pullEvents());
    }
}
