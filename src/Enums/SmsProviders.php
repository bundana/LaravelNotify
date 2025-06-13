<?php

namespace Bundana\LaravelSmsNotify\Enums;

enum SmsProviders: string
{
    use BaseEnum;

    case MNOTIFY = 'mnotify';
    case HUBTEL = 'hubtel';
    case NALO = 'nalo';
}
