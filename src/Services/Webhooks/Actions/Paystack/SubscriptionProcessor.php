<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

class SubscriptionProcessor
{
}

// 'subscription.create',
// 1. update subscription on product subscription table
// 2. send sms/email to customer about successfully subscribing to a product
// 3. notify vendor about subscription

// 'subscription.disable',
// 1. update subscription on product subscription table on state disabled
// 2. send sms/email to customer about cancelling subscribing to a product
// 3. notify vendor about subscription cancellation

// 'subscription.enable'
// 1. enable subscription on product subscription table on state active
// 2. send sms/email to customer about cancelling subscribing to a product
// 3. notify vendor about subscription cancellation

// 'subscription.not_renew'
// 1. not renew subscription on product subscription table on state not renewing
// 2. send sms/email to customer about about not renvew subscribing to a product
// 3. notify vendor about subscription not renewing

// 'subscription.expiring_cards'
// update state not renewing expiring_cards
// send message to the customer with the link to update his expiring card
