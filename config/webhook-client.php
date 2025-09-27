<?php

use Spatie\WebhookClient\Models\WebhookCall;

return [
    'configs' => [
        [
            'name' => 'webhook-payments-robokassa',
            'signing_secret' => 'secret-for-webhook-sending-app-1',
            'signature_header_name' => 'Signature-for-app-1',
            'webhook_model' => WebhookCall::class,
        ],

        /*
        [
            'name' => 'webhook-whats-app',
            'signing_secret' => 'secret-for-webhook-sending-app-1',
            'signature_header_name' => 'Signature-for-app-1',
            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => ProcessPaymentWebhookJob::class,
        ]
        */
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * 7 deletes all records after 1 week. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,
];
