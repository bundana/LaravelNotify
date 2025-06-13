# Laravel SMS Notify

A flexible and powerful SMS notification package for Laravel applications. This package provides a unified interface for sending SMS notifications through multiple providers including Mnotify, Hubtel, and Nalo.

## Features

-   🚀 Multiple SMS Provider Support (Mnotify, Hubtel, Nalo)
-   📝 SMS Builder for Fluent Message Construction
-   📨 Queue and Scheduling Support
-   📋 Template Management (Mnotify)
-   👥 Group Management (Mnotify)
-   📊 Detailed Reports and Analytics
-   ✅ Comprehensive Test Coverage
-   📚 Detailed Documentation

## Installation

```bash
composer require bundana/laravel-sms-notify:^1.0.0-beta.3
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Bundana\LaravelSmsNotify\LaravelSmsNotifyServiceProvider"
```

Configure your `.env` file:

```env
SMS_PROVIDER=mnotify
MNOTIFY_API_KEY=your_api_key
MNOTIFY_SENDER_ID=your_sender_id
```

## Quick Start

```php
use Bundana\LaravelSmsNotify\Facades\Sms;

// Simple SMS
Sms::to('+233123456789')
   ->message('Hello from Laravel SMS Notify!')
   ->send();

// Using Templates (Mnotify)
Sms::to('+233123456789')
   ->template('welcome', ['name' => 'John'])
   ->send();

// Queue Support
Sms::to('+233123456789')
   ->message('This will be queued')
   ->queue();

// Schedule Support
Sms::to('+233123456789')
   ->message('This will be sent later')
   ->schedule(now()->addHours(2));
```

## Advanced Usage

### Group Management (Mnotify)

```php
use Bundana\LaravelSmsNotify\Facades\Sms;

// Create a group
$group = Sms::group()->create('VIP Customers');

// Add contacts to group
Sms::group()->addContacts($group->id, ['+233123456789', '+233987654321']);

// Send to group
Sms::toGroup($group->id)
   ->message('Special offer for VIP customers!')
   ->send();
```

### Template Management (Mnotify)

```php
use Bundana\LaravelSmsNotify\Facades\Sms;

// Create template
$template = Sms::template()->create(
    'welcome',
    'Welcome {name} to our service!'
);

// Update template
Sms::template()->update(
    $template->id,
    'Welcome {name} to our amazing service!'
);

// Send using template
Sms::to('+233123456789')
   ->template('welcome', ['name' => 'John'])
   ->send();
```

### Reports and Analytics

```php
use Bundana\LaravelSmsNotify\Facades\Sms;

// Get delivery reports
$reports = Sms::report()->getDeliveryReports();

// Get balance
$balance = Sms::report()->getBalance();
```

## Requirements

-   PHP 8.2 or higher
-   Laravel 9.x, 10.x, or 11.x
-   Guzzle 7.8 or higher

## Testing

```bash
composer test
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
