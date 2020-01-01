<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Api Key
      |--------------------------------------------------------------------------
      |
      | The zadarma API key. You can find it or create a new one in the
      | API authentication tab of the application section in the Zadarma dashboard
      | https://dashboard.zadarma.me/apps/<YOUR_APP_ID>/auth
     */
    'api_key' => env('ZADARMA_API_KEY'),
    /*
      |--------------------------------------------------------------------------
      | Api Secret
      |--------------------------------------------------------------------------
      |
      | The zadarma API secret key. You can find it or create a new one in the
      | API authentication tab of the application section in the Zadarma dashboard
      | https://dashboard.zadarma.me/apps/<YOUR_APP_ID>/auth
     */
    'api_secret' => env('ZADARMA_API_SECRET'),
    /*
      |--------------------------------------------------------------------------
      | Is Channel Active
      |--------------------------------------------------------------------------
      |
      | Activates or deactivates the Zadarma channel.
     */
    'is_channel_active' => (bool) env('ZADARMA_CHANNEL_ACTIVE', true),
    /*
      |--------------------------------------------------------------------------
      | Request Retries
      |--------------------------------------------------------------------------
      |
      | Specifies the number of retries when receiving a 500 error response.
     */
    'request_retries' => env('ZADARMA_REQUEST_RETRIES', 3),
];
