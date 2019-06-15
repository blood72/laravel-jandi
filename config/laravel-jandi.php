<?php

return [
    /*
    |--------------------------------------------------------------------------
    | JANDI Webhook URL
    |--------------------------------------------------------------------------
    | This is the URL that will be sent by default through the JANDI notifier.
    | You can have an array value, in which case the request will be sent to each URL.
    |
    */

    'jandi_webhook_url' => env('JANDI_WEBHOOK_URL', 'https://{webhook_type}.jandi.com/connect-api/webhook/{team_id}/{payload_token}'),
];
