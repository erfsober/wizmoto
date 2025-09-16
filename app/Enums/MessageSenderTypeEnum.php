<?php

namespace App\Enums;

enum MessageSenderTypeEnum: string
{
    case GUEST = 'guest';
    case PROVIDER = 'provider';
}
