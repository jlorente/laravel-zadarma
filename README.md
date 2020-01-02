Zadarma SDK for Laravel
=======================
Laravel integration for the [Zadarma SDK](https://github.com/jlorente/zadarma-php-sdk) including two notification channels.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require jlorente/laravel-zadarma
```

or add 

```json
...
    "require": {
        "jlorente/laravel-zadarma": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \Jlorente\Laravel\Zadarma\ZadarmaServiceProvider::class,
    ];
];
```

2. Add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'Zadarma' => \Jlorente\Laravel\Zadarma\Facades\Zadarma::class,
    ];
];
```

3. Set the api_key in the config/zadarma.php file or use the predefined env 
variables.

config/zadarma.php
```php
return [
    'api_key' => 'YOUR_API_KEY',
    'api_secret' => 'YOUR_API_SECRET',
    //other configuration
];
```
or 
.env
```
//other configurations
ZADARMA_API_KEY=<YOUR_API_KEY>
ZADARMA_API_SECRET=<YOUR_API_SECRET>
```

## Usage

You can use the facade alias Zadarma to execute api calls. The authentication 
params will be automaticaly injected.

```php
Zadarma::api()->getBalance();
```

## Notification Channels

Two notification channels are included in this package and allow you to integrate 
the Zadarma send SMS service and the phone call request callback with the Laravel 
notifications.

You can find more info about Laravel notifications in [this page](https://laravel.com/docs/5.6/notifications).

### ZadarmaSmsChannel

If you want to send an SMS through Zadarma, you should define a toZadarmaSms method 
on the notification class. This method will receive a $notifiable entity and 
should return a string with the message to be sent on the SMS:

```php
/**
 * Get the SMS message.
 *
 * @param  mixed  $notifiable
 * @return string
 */
public function toZadarmaSms($notifiable)
{
    return 'Hello, this is an SMS sent through Zadarma API';
}
```

Once done, you must add the notification channel in the array of the via() method 
of the notification:

```php
/**
 * Get the notification channels.
 *
 * @param  mixed  $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return [ZadarmaSmsChannel::class];
}
```

### ZadarmaPhoneCallChannel

If you want to stablish a phone call by request callback through the Zadarma API, you 
should define a toZadarmaPhoneCall method on the notification class. This method will 
receive a $notifiable entity and should return a phone/SIP number, a PBX extension number or 
the PBX scenario to which the callback will be made.

```php
/**
 * Gets a phone/SIP number, a PBX extension number or a PBX scenario to which the 
 * phone callback will be made.
 *
 * @param mixed $notifiable
 * @return string
 */
public function toZadarmaPhoneCall($notifiable)
{
    return 100;
}
```

Once done, you must add the notification channel in the array of the via() method 
of the notification:

```php
/**
 * Get the notification channels.
 *
 * @param mixed $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return [ZadarmaPhoneCallChannel::class];
}
```

### Routing the Notifications

When sending notifications via Zadarma channel, the notification system will 
automatically look for a phone_number attribute on the notifiable entity. If 
you would like to customize the number you should define a routeNotificationForZadarma 
method on the entity:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Zadarma channels.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForZadarma($notification)
    {
        return $this->phone;
    }
}
```

## License 
Copyright &copy; 2019 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
