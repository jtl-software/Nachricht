<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/17
 */

namespace JTL\Nachricht\Serializer;

use JTL\Nachricht\Contract\Event\Event;
use JTL\Nachricht\Contract\Serializer\EventSerializer;
use JTL\Nachricht\Serializer\Exception\DeserializationFailedException;

class PhpEventSerializer implements EventSerializer
{
    /**
     * @param object $event
     * @return string
     */
    public function serialize(object $event): string
    {
        return serialize($event);
    }

    /**
     * @param string $serializedEvent
     * @return Event
     * @throws DeserializationFailedException
     */
    public function deserialize(string $serializedEvent): object
    {
        $result = @unserialize($serializedEvent);

        if ($result === false || !$result instanceof Event) {
            throw new DeserializationFailedException();
        }

        return $result;
    }
}
