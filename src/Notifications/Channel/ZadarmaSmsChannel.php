<?php

/**
 * Part of the Zadarma Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Zadarma Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\Zadarma\Notifications\Channel;

use Illuminate\Notifications\Notification;
use Jlorente\Zadarma\Zadarma;

/**
 * Class ZadarmaSmsChannel.
 * 
 * A notification channel to send sms messages through Zadarma API.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class ZadarmaSmsChannel
{

    /**
     * The Zadarma client instance.
     *
     * @var Zadarma
     */
    protected $client;

    /**
     * Create a new Zadarma channel instance.
     *
     * @param Zadarma $client
     * @return void
     */
    public function __construct(Zadarma $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|bool
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('zadarma', $notification)) {
            $to = $notifiable->phone_number;
            if (!$to) {
                return;
            }
        }

        $message = $notification->toZadarmaSms($notifiable);

        if (config('zadarma.is_channel_active') === true) {
            return $this->client->api()->sendSms($to, $message);
        } else {
            return true;
        }
    }

}
