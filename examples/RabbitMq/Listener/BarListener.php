<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/21
 */

namespace JTL\Nachricht\Examples\RabbitMq\Listener;


use JTL\Nachricht\Contracts\Event\Event;
use JTL\Nachricht\Contracts\Listener\Listener;

class BarListener implements Listener
{

    public function execute(Event $event): bool
    {
        echo 'Bar Listener called: ' . $event->getData() . "\n";
        throw new \Exception();
        return !!random_int(0, 1);
    }
}