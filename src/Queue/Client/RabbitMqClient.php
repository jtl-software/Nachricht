<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/17
 */

namespace JTL\Nachricht\Queue\Client;


use Closure;
use JTL\Nachricht\Contracts\Event\Event;
use JTL\Nachricht\Contracts\Queue\Client\MessageClient;
use JTL\Nachricht\Contracts\Serializer\EventSerializer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqClient implements MessageClient
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var EventSerializer
     */
    private $serializer;

    /**
     * @var AMQPChannel
     */
    private $channel;


    public function __construct(EventSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function connect(ConnectionSettings $connectionSettings): MessageClient
    {
        $this->connection = new AMQPStreamConnection(
            $connectionSettings->getHost(),
            $connectionSettings->getPort(),
            $connectionSettings->getUser(),
            $connectionSettings->getPassword()
        );
        $this->channel = $this->connection->channel();
        return $this;
    }

    /**
     * @param Event $event
     */
    public function publish(Event $event): void
    {
        $amqpMessage = new AMQPMessage($this->serializer->serialize($event));
        $this->channel->basic_publish($amqpMessage, $event->getExchange(), $event->getRoutingKey());
    }

    public function subscribe(SubscriptionSettings $subscriptionOptions, Closure $handler): MessageClient
    {
        foreach ($subscriptionOptions->getQueueNameList() as $queue) {
            $this->channel->queue_declare($queue, false, true, false, false);
            $this->channel->basic_consume(
                $queue,
                '',
                false,
                false,
                false,
                false,
                $this->createCallbackFromDispatcher($handler)
            );
        }

        return $this;
    }

    public function poll(): void
    {
        $this->channel->wait();
    }

    /**
     * @return Closure
     */
    private function createCallbackFromDispatcher($handler): Closure
    {
        $serializer = $this->serializer;
        return static function(AMQPMessage $data) use ($serializer, $handler) {
            /** @var AMQPChannel $channel */
            $channel = $data->delivery_info['channel'];
            $event = $serializer->deserialize($data->getBody());

            try {
                $result = $handler($event);
            } catch (\Exception|\Throwable $e) {
                $channel->basic_nack($data->delivery_info['delivery_tag'], false, true);
                echo "There was an exception\n";
                return;
            }

            if ($result === true) {
                $channel->basic_ack($data->delivery_info['delivery_tag']);
                echo "Everything OK\n";
            } else {
                $channel->basic_nack($data->delivery_info['delivery_tag']);
                echo "Task failed successfully\n";
            }

            echo "--- done ---\n\n";
        };
    }
}
