<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/20
 */

namespace JTL\Nachricht\Contract\Emitter;

use JTL\Nachricht\Contract\Event\Event;

interface Emitter
{
    /**
     * @param Event $event
     */
    public function emit(Event $event): void;
}