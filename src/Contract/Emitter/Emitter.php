<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/20
 */

namespace JTL\Nachricht\Contract\Emitter;

use JTL\Nachricht\Contract\Message\Message;

interface Emitter
{
    /**
     * @param Message ...$messageList
     */
    public function emit(Message ...$messageList): void;
}
