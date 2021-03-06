<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/05/22
 */

namespace JTL\Nachricht\Contract\Transport;

use JTL\Nachricht\Transport\SubscriptionSettings;

interface Consumer
{
    /**
     * @param SubscriptionSettings $subscriptionSettings
     */
    public function consume(SubscriptionSettings $subscriptionSettings): void;
}
