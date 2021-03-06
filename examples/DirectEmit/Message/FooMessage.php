<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/20
 */

namespace JTL\Nachricht\Examples\DirectEmit\Message;

use JTL\Nachricht\Contract\Message\Message;

class FooMessage implements Message
{
    private $fooProperty;

    /**
     * FooMessage constructor.
     * @param $fooProperty
     */
    public function __construct($fooProperty)
    {
        $this->fooProperty = $fooProperty;
    }

    /**
     * @return mixed
     */
    public function getFooProperty()
    {
        return $this->fooProperty;
    }
}
