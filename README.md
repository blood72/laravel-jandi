# JANDI notification channel for Laravel 5

[JANDI](https://www.jandi.com) is business collaboration messenger tool made by Toss Lab, Inc.  
This package is non-official and only provides a notification channel for JANDI incoming webhook connection.


## Index

- [Requirement](#requirement)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Reference](#reference)
- [License](#license)


## Requirement

- PHP >= 7.2
- Laravel 5.8+ or 6.0


## Installation

Install using the composer.
```bash
composer require blood72/laravel-jandi
```

**Additional work required if Auto-Discovery is disabled.**

add the service provider to the `providers` array in `config/app.php`.
```php
'providers' => [
    // ...
    Blood72\Jandi\JandiServiceProvider::class,
],
```

also add this to the `aliases` array to use JANDI notifier.
```php
'aliases' => [
    // ...
    'Jandi' => \Blood72\Jandi\JandiFacade::class,
],
```

if you don't want to use JANDI notifier, follow the instructions below.  
1. add disable auto-discovery code in ```composer.json```
    ```json
    {
        "extra": {
            "laravel": {
                "dont-discover": [
                    "blood72/laravel-jandi"
                ]
            }
        }
    }
    ```
2. add this code in register() method in your service provider.
    ```php
    use Blood72\Jandi\Notifications\Channels\JandiWebhookChannel;
    use GuzzleHttp\Client as HttpClient;
    use Illuminate\Notifications\ChannelManager;
    use Illuminate\Support\Facades\Notification;

    // ...

    Notification::resolved(function (ChannelManager $service) {
        $service->extend('jandi', function ($app) {
            return new JandiWebhookChannel(new HttpClient);
        });
    });
    ```


## Configuration

By default, this package supports only one webhook url.
```dotenv
JANDI_WEBHOOK_URL=https://wh.jandi.com/connect-api/webhook/{team_id}/{payload_token}
```

you can publish a configuration file.
```bash
php artisan vendor:publish --provider="Blood72\Jandi\JandiServiceProvider"
```

and you can customize like this. in this case, a request will be sent to each URL.
```php
'jandi_webhook_url' => [
    env('JANDI_WEBHOOK_URL_1'),
    env('JANDI_WEBHOOK_URL_2'),
    // ... and so all
],
```


## Usage

- #### Message
    - to(): set a email for the Jandi team message (optional).
        ```php
        $message = (new JandiMessage)->to('test@example.org');
        ```

    - content(): set the content of the Jandi message.
        ```php
        $message = (new JandiMessage)->content('hello test');
        ```
        create new object with content; __construct(), create()
        ```php
        $message = new JandiMessage('hello test');
        $message = JandiMessage::create('hello test');
        ```
    - color(): set the color of the attachment section.
        ```php
        $message->color('#000000');
        $message->color('#30fe2a');
        ```
        it supports bootstrap 4 color scheme.
        ```php
        $message->primary();
        $message->secondary();
        $message->success();
        $message->danger();
        $message->warning();
        $message->info();
        $message->light();
        $message->dark();
        ```
    - attachment(): define an attachment for the message. you can add multiple.
        ```php
        $message->attachment(function ($attachment) {
            $attachment->title('attachment-title');
            $attachment->description('attachment-description');
            $attachment->image('attachment-image-url');
        });
        
        $message->attachment(function ($attachment) {
            $attachment->title('attachment-title');
            $attachment->description('attachment-description');
            $attachment->image('attachment-image-url');
        })->attachment(function ($attachment) {
            $attachment->title('attachment-another-title');
            $attachment->description('attachment-another-description');
            $attachment->image('attachment-another-image-url');
        });
        ```

- #### Notification
    - notification override  
        you can use an abstract class defined. it requires definition of toJandi() method.
        ```php
        use Blood72\Jandi\Notifications\JandiNotification;
        
        class JandiExampleNotification extends JandiNotification
        {
            public function toJandi($notifiable/* = null*/): JandiMessage
            {
                return (new JandiMessage)->to('test@example.org')->content('hello test');
            }
        }
        ```
    - send notification  
        - by anonymous notifiable  
            ```php
            use Illuminate\Notifications\AnonymousNotifiable;
            use Illuminate\Support\Facades\Notification;

            Notification::send(new AnonymousNotifiable, new JandiExampleNotification
            ```
        - by notifiable model  
            to use this, ```routeNotificationForJandi()``` must be defined.
            ```php
            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Notifications\Notifiable;
            
            class ExampleNotifiableModel extends Model
            {
                use Notifiable;

                public function routeNotificationForJandi()
                {
                    return 'hello routeNotificationForJandi() test';
                }
            }
            ```
            ```php
            $notifiable = new ExampleNotifiableModel;
            
            $notification->send($notifiable, new JandiExampleNotification);
            ```

- #### Facade
    It supports the JandiNotifier class as a 'Jandi' facade.

    - send(): you can send message simply.
        - it is sent based on the default route settings.  
            ```php
            use Blood72\Jandi\Notifications\Messages\JandiMessage;

            $message = JandiMessage::create('hello test');
            // or $message = new JandiMessage('hello test');
            
            Jandi::send($message);
            ```
        - of course, it can be done in a simple string form.  
            ```php
            Jandi::send('hello test')
            ```
        - you can set other notification class if you don't want to use default one.
            ```php
            Jandi::send('hello test', YourOtherNotification::class);
            ```

    - to(): you can specify the recipient URL(s).  
        - by string  
            ```php
            Jandi::to('jandi-webhook-url')->content('hello test');
             ```
        - by multiple params  
            ```php
            Jandi::to('jandi-webhook-url-1', 'jandi-webhook-url-2')->content('hello test');
            ```
        - by array  
            ```php
            Jandi::to([
                'jandi-webhook-url-1',
                'email-1' => 'jandi-webhook-url-2',
                'email-2' => [
                    'jandi-webhook-url-3',
                    'jandi-webhook-url-4',
                ],
            ]);
            ```
            you can set email when sending 1:1 chat for team chat webhook URL (paid team only).
            email does not validate in jandi, and to send together, it must be string.
        - by object  
            to use this, ```routeNotificationForJandi()``` or ```jandi_webhook_url``` must be defined.
            it can be defined ```jandi_webhook_url``` as ```getJandiWebhookUrlAttribute()```.
            ```php           
            use App\User;
            
            public function routeNotificationForJandi()
            {
                return 'url';
            }

            // in example, $user is User model instance.
            
            Jandi::to($user)->send('hello test');
            ```
            if you want to set email, ```jandi_email``` (or ```getJandiEmailAttribute()```) is required.



## Reference

- JANDI [incoming webhook guide](https://support.jandi.com/hc/en-us/articles/210867283-Receiving-incoming-Webhooks-in-JANDI)
  and [for team one](https://support.jandi.com/hc/en-us/articles/360025062132-Team-Incoming-Webhook)
- Laravel official [Slack notification channel](https://github.com/laravel/slack-notification-channel)
- Guilherme Pressutto's [laravel-slack](https://github.com/gpressutto5/laravel-slack)

... and based on a code written by [@kwonmory](https://github.com/kwonmory)


## License

This package is open-sourced software licensed under the MIT license.
