<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

class InvoiceProcessor
{
    public function execute(array $payload): void
    {
        match ($payload['event']) {
            'invoice.create' => $this->createInvoice($payload),
            'invoice.payment_failed' => $this->paymentFailed($payload),
            'invoice.update' => $this->updateInvoice($payload),
        };
    }

    protected function createInvoice(array $data)
    {
        //notify customer about the impending subscription payment
    }

    protected function paymentFailed(array $data)
    {
        //status
        //descritpion
        //open invoice
        //card_type
    }

    protected function updateInvoice(array $data)
    {
        //subscription_code
        //card_type
        //next_payment_due
        //status
    }
}

//invoice.create
// Remind the customer subscription is almost due for renewal

//invoice.payment_failed
//notify customer subscription payment
//option to retry

//invoice.update
//notify customer subscription has been successfully renewed
