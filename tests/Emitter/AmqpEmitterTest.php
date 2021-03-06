<?php declare(strict_types=1);
/**
 * This file is part of the jtl-software/nachricht
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) JTL-Software-GmbH
 * @author pkanngiesser
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://packagist.org/packages/jtl/nachricht Packagist
 * @link https://github.com/jtl-software/nachricht GitHub
 */

namespace JTL\Nachricht\Emitter;

use JTL\Nachricht\Contract\Message\AmqpTransportableMessage;
use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\Nachricht\Emitter\AmqpEmitter
 */
class AmqpEmitterTest extends TestCase
{
    public function testCamEmitMessage(): void
    {
        $messageStub = $this->createStub(AmqpTransportableMessage::class);

        $transportMock = $this->createMock(AmqpTransport::class);
        $transportMock->expects($this->once())->method('publish')->with($messageStub);

        $emitter = new AmqpEmitter($transportMock);
        $emitter->emit($messageStub);
    }

    public function testCanEmitMessageList(): void
    {
        $messageStub = $this->createStub(AmqpTransportableMessage::class);

        $transportMock = $this->createMock(AmqpTransport::class);
        $transportMock->expects($this->exactly(4))->method('publish')->with($messageStub);

        $emitter = new AmqpEmitter($transportMock);
        $emitter->emit($messageStub, $messageStub, $messageStub, $messageStub);
    }
}
