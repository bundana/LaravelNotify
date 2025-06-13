# Laravel SMS Notify

A fluent API for sending SMS via multiple providers in Laravel. This package supports Mnotify, Hubtel, and Nalo SMS providers.

## Installation

You can install the package via composer:

```bash
composer require Bundana/laravel-sms-notify
```

After installing the package, publish the configuration file:

```bash
php artisan vendor:publish --provider="Bundana\LaravelSmsNotify\SmsServiceProvider" --tag="config"
```

## Configuration

Add the following environment variables to your `.env` file:

```env
SMS_PROVIDER=mnotify

# Mnotify Configuration
MNOTIFY_API_KEY=your_api_key
MNOTIFY_SENDER_ID=your_sender_id
MNOTIFY_BASE_URL=https://api.mnotify.com/api/

# Hubtel Configuration
HUBTEL_CLIENT_ID=your_client_id
HUBTEL_CLIENT_SECRET=your_client_secret
HUBTEL_SENDER_ID=your_sender_id
HUBTEL_BASE_URL=https://smsc.hubtel.com/v1/

# Nalo Configuration
NALO_API_KEY=your_api_key
NALO_SENDER_ID=your_sender_id
NALO_BASE_URL=https://sms.nalosolutions.com/api/
```

## Usage

### Basic Usage

```php
use Bundana\LaravelSmsNotify\Facades\Sms;

// Send an immediate SMS
Sms::to('+233201234567')
    ->message('Hello from Laravel!')
    ->send();

// Send with a specific provider
Sms::to('+233201234567')
    ->provider('hubtel')
    ->message('Hello from Laravel!')
    ->from('SCEF')
    ->send();
```

### Queued SMS

```php
// Queue an SMS for later processing
Sms::to('+233201234567')
    ->message('This will be queued')
    ->queue()
    ->send();
```

### Scheduled SMS

```php
// Schedule an SMS for future delivery
Sms::to('+233201234567')
    ->message('This will be sent in 5 minutes')
    ->queue()
    ->schedule(now()->addMinutes(5))
    ->send();
```

## Available Methods

-   `to(string $number)`: Set the recipient's phone number
-   `message(string $message)`: Set the message content
-   `from(string $sender)`: Set the sender's name or number
-   `provider(string $provider)`: Set the SMS provider (mnotify, hubtel, nalo)
-   `queue()`: Mark the message for queuing
-   `schedule(\DateTimeInterface $time)`: Schedule the message for future delivery
-   `send()`: Send the message

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email Bundana@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
