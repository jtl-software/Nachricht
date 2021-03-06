<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/11
 */

namespace JTL\Nachricht\Message\Cache;

class MessageCache
{
    /**
     * @var array<string, array{listenerList: array<int, array{listenerClass: string, method: string}>, routingKey: string}>
     */
    private array $listenerCache;

    /**
     * ListenerCache constructor.
     * @param array<string, array{listenerList: array<int, array{listenerClass: string, method: string}>, routingKey: string}> $listenerCache
     */
    public function __construct(array $listenerCache)
    {
        $this->listenerCache = $listenerCache;
    }

    /**
     * @param string $messageClass
     * @return array<int, array{listenerClass: string, method: string}>
     */
    public function getListenerListForMessage(string $messageClass): array
    {
        return $this->listenerCache[$messageClass]['listenerList'] ?? [];
    }

    /**
     * @return array<int, string>
     */
    public function getMessageClassList(): array
    {
        return array_keys($this->listenerCache);
    }

    /**
     * @param string $messageClass
     * @return string|null
     */
    public function getRoutingKeyForMessage(string $messageClass): ?string
    {
        return $this->listenerCache[$messageClass]['routingKey'] ?? null;
    }
}
